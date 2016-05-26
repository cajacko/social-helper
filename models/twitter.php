<?php

require_once('vendor/autoload.php');
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

    public function get_tweets($tag, $since_id = false, $max_id = false) {
        $this->set_app_connection();

        $twitter_search_array = array( 
            'q' => '#' . $tag['tag'] .' filter:links -filter:retweets', 
            "count" => 100, 
            'exclude_replies' => TRUE,
            'lang' => 'en',
            'result_type' => 'recent',
        );

        if($since_id) {
            $twitter_search_array['since_id'] = $since_id;
        }

        if($max_id) {
            $twitter_search_array['max_id'] = $max_id;
        }

        $tweet_response = $this->connection->get( "search/tweets", $twitter_search_array);   

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

    public function add_tweet_tag_rel($tweet_id, $tracking_tag_id) {
        $query = '
            INSERT INTO tweet_tracking_tags (tweet_id, tracking_tag_id)
            VALUES (?, ?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $tweet_id, $tracking_tag_id);
        $stmt->execute();

        if($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
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

    public function update_last_tweet($tweets, $tag) {
        $query = '
            UPDATE tracking_tags
            SET last_processed = ?
            WHERE id = ?
        ;';

        $tweet_id = $tweets->statuses[0]->id;
        $tweet_id++;

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "ii", 
            $tweets->statuses[0]->id,
            $tag['id']
        );

        $stmt->execute();

        if($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function save_new_tweets() {
        require_once('models/tags.php');
        $tags = new Tags($this->db);
        $tags_to_process = $tags->get_all_tags();

        foreach($tags_to_process as $tag) {
            $since_id = $tag['last_processed']; // The most recent tweet we already had for this search
            $max_id = false; // Oldest tweet id in the current set
            $continue_while = true;
            $i = 0;

            while($continue_while && $i < 100) {
                $tweets = $this->get_tweets($tag, $since_id, $max_id); 

                if(isset($tweets->statuses) && count($tweets->statuses)) {
                    $this->update_last_tweet($tweets, $tag);

                    foreach($tweets->statuses as $tweet) {
                        $tweet_id = $this->does_tweet_exist($tweet->id);

                        if($tweet_id) {
                            $this->update_tweet($tweet_id, $tweet); // Need to figure out when we update tweets,or if we do or not?
                        } else {
                            $tweet_id = $this->save_tweeet($tweet);
                            $this->add_tweet_tag_rel($tweet_id, $tag['id']);
                        }

                        $i++;
                        $max_id = $tweet->id;
                        $max_id--;
                    }
                } else {
                    $continue_while = false;
                    break;
                }
            }
        }
    }

    public function get_tweet_meta($tweet_id) {
        $query = '
            SELECT tweets.*, tweet_tags.tag
            FROM tweets
            LEFT JOIN tweet_tags
                ON tweet_tags.tweet_id = tweets.id
            WHERE tweets.id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $tweet_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            $tags = [];

            while($tag = $res->fetch_assoc()) {
                $tags[] = $tag['tag'];
                $tweet = $tag;
            }

            unset($tweet['tag']);
            $tweet['hashtags'] = $tags;

            return $tweet;
        } else {
            return false;
        }
    }
}
