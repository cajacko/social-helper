<?php

require_once('../vendor/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter {
    private $key;
    private $secret;
    private $callback;
    private $connection;
    private $db;
    private $token;
    private $token_secret;
    private $connection_type = false;

    public function __construct($db, $config) {
        $this->db = $db;
        $this->key = $config->twitter->key;
        $this->secret = $config->twitter->secret;
        $this->callback = $config->twitter->callback;
        $this->connection = new TwitterOAuth($this->key, $this->secret);
        $this->connection_type = 'temp';
    }

    public function login_url() {
        $temporary_credentials = $this->connection->oauth('oauth/request_token', array("oauth_callback" => $this->callback));
        $_SESSION['oauth_token'] = $temporary_credentials['oauth_token'];       
        $_SESSION['oauth_token_secret'] = $temporary_credentials['oauth_token_secret'];
        return $this->connection->url("oauth/authorize", array("oauth_token" => $temporary_credentials['oauth_token']));       
    }

    public function login() {
        $url = $this->login_url();
        header('Location: ' . $url); 
        exit;
    }

    public function get_tokens() {
        if(isset($_GET['oauth_verifier'], $_GET['oauth_token'])) {
            $params = array(
                "oauth_verifier" => $_GET['oauth_verifier'], 
                "oauth_token" => $_GET['oauth_token']
            );

            return $this->connection->oauth("oauth/access_token", $params);
        } else {
            return false;
        }
    }

    public function set_user_connection() {
        if('user' == $this->connection_type) {
            return true;
        } else {
            $this->connection = new TwitterOAuth(
                $this->key, 
                $this->secret, 
                $_SESSION['oauth_token'], 
                $_SESSION['oauth_token_secret']
            );

            $this->connection_type = 'user';
            return true;
        }
    }

    public function set_app_connection() {
        if('app' == $this->connection_type) {
            return true;
        } else {
            $result = $this->connection->oauth2('oauth2/token', array('grant_type' => 'client_credentials'));
            $this->connection_type = 'app';
            return true;
        }
    }

    public function get_tweets($tag) {
        $this->set_app_connection();

        $tweet_response = $this->connection->get( "search/tweets", array( 
            'q' => '#' . $tag['tag'] .' filter:links -filter:retweets', 
            "count" => 10, 
            'exclude_replies' => TRUE,
            'lang' => 'en',
            'result_type' => 'recent',
        ));   

        return $tweet_response;
    }

    public function does_tweet_exist($tweet_id) {
        $query = '
            SELECT tweets.id
            FROM tweets
            WHERE tweets.tweet_id = ?
            LIMIT 1
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $tweet_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            $tweet = $res->fetch_assoc();
            return $tweet['id'];
        } else {
            return false;
        }
    }

    public function save_tweet_link($id, $link) {
        $query = '
            INSERT INTO tweet_links (tweet_id, link)
            VALUES (?, ?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $id, $link);
        $stmt->execute();

        if($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function save_tweet_links($id, $tweet) {
        foreach($tweet->entities->urls as $link) {
            $this->save_tweet_link($id, $link->expanded_url);
        }
    }

    public function save_tweet_tag($id, $tag) {
        $query = '
            INSERT INTO tweet_tags (tweet_id, tag)
            VALUES (?, ?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $id, $tag);
        $stmt->execute();

        if($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function save_tweet_tags($id, $tweet) {
        foreach($tweet->entities->hashtags as $tag) {
            $this->save_tweet_tag($id, $tag->text);
        }
    }

    public function save_tweeet($tweet) {
        $query = '
            INSERT INTO tweets (tweet_id, user_id, tweet, date, retweets, favourites)
            VALUES (?, ?, ?, ?, ?, ?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "iissii", 
            $tweet->id, 
            $tweet->user->id,
            $tweet->text,
            $tweet_date,
            $tweet->retweet_count,
            $tweet->favorite_count
        );

        $tweet_date = strtotime($tweet->created_at);
        $stmt->execute();

        if($stmt->insert_id) {
            $this->save_tweet_links($stmt->insert_id, $tweet);
            $this->save_tweet_tags($stmt->insert_id, $tweet);
            return $stmt->insert_id;
        } else {
            return false;
        }
    } 

    public function update_tweet($id, $tweet) {
        $query = '
            UPDATE tweets
            SET retweets = ?, favourites = ?
            WHERE tweet_id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "iii", 
            $tweet->retweet_count,
            $tweet->favorite_count,
            $tweet->id
        );

        $stmt->execute();

        if($stmt) {
            return $id;
        } else {
            return false;
        }
    }

    public function save_new_tweets() {
        require_once('tags.php');
        $tags = new Tags($this->db);
        $tags_to_process = $tags->get_all_tags();

        foreach($tags_to_process as $tag) {
            $tweets = $this->get_tweets($tag);

            foreach($tweets->statuses as $tweet) {
                $tweet_id = $this->does_tweet_exist($tweet->id);

                if($tweet_id) {
                    $this->update_tweet($tweet_id, $tweet);
                } else {
                    $tweet_id = $this->save_tweeet($tweet);
                }
            }
        }
    }
}
