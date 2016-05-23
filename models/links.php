<?php
class Links {
    private $db;
    private $config;

    public function __construct($db, $config) {
        $this->db = $db;
        $this->config = $config;
    }

    public function get_links() {
        $links = array();

        $query = '
            SELECT tweet_links.link, tweet_links.tweet_id, tweet_tracking_tags.tracking_tag_id
            FROM tweets
            INNER JOIN tweet_links
                ON tweets.id = tweet_links.tweet_id
            INNER JOIN tweet_tracking_tags
                ON tweets.id = tweet_tracking_tags.tweet_id
            WHERE tweets.processed IS NULL
            ORDER BY tweets.id DESC
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            while($link = $res->fetch_assoc()) {
                $links[] = array('tweet_id' => $link['tweet_id'], 'link' => $link['link'], 'tracking_tag_id' => $link['tracking_tag_id']);
            }

            return $links;
        } else {
            return false;
        }
    }

    public function resolve_url($link) {
        require_once('helpers/parse-url.php');
        $parser = new Parse_url;
        return $parser->resolve($link);
    }

    public function does_link_exist($link) {
        $query = '
            SELECT id
            FROM links
            WHERE link = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $link);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            $link = $res->fetch_assoc();
            return $link['id'];
        } else {
            return false;
        }
    }

    public function save_link($link) {
        if($link_id = $this->does_link_exist($link)) {
            return $link_id;
        }

        $query = '
            INSERT INTO links (link)
            VALUES (?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $link);
        $stmt->execute();

        if($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function save_link_tweet($link_id, $tweet_id) {
        $query = '
            INSERT INTO link_tweets (link_id, tweet_id)
            VALUES (?, ?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $link_id, $tweet_id);
        $stmt->execute();

        if($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function update_tweet_processed($tweet_id) {
        $query = '
            UPDATE tweets
            SET processed = ?
            WHERE id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "ii", 
            $timestamp,
            $tweet_id
        );

        $timestamp = time();

        $stmt->execute();

        if($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function add_link_tracking_tag_rel($link_id, $tracking_tag_id) {
        $query = '
            INSERT INTO link_tracking_tags (link_id, tracking_tag_id)
            VALUES (?, ?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $link_id, $tracking_tag_id);
        $stmt->execute();

        if($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function process_links() {
        $links = $this->get_links();

        foreach($links as $link) {
            $resolved_url = $this->resolve_url($link['link']);
            $link_id = $this->save_link($resolved_url);
            $this->save_link_tweet($link_id, $link['tweet_id']);
            $this->update_tweet_processed($link['tweet_id']);
            $this->add_link_tracking_tag_rel($link_id, $link['tracking_tag_id']);
        }
    }

    public function get_link_tweets($id) {
        $tweets = array();

        $query = '
            SELECT tweets.*
            FROM tweets
            INNER JOIN link_tweets
                ON link_tweets.tweet_id = tweets.id
            WHERE link_tweets.link_id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            while($tweet = $res->fetch_assoc()) {
                $tweets[] = array(
                    'tweet' => $tweet['tweet'], 
                    'user' => $tweet['user_id'], 
                    'username' => $tweet['user_id'], 
                    'url' => 'https://twitter.com/Vikiibell/status/' . $tweet['tweet_id'], 
                    'date' => $tweet['date'], 
                    'id' => $tweet['id'], 
                );
            }

            return $tweets;
        } else {
            return false;
        }
    }

    public function get_top_links($user_id) {
        $links = array();

        $query = '
            SELECT links.*
            FROM links
            LEFT JOIN user_links
                ON user_links.link_id = links.id
            INNER JOIN link_tracking_tags
                ON link_tracking_tags.link_id = links.id
            INNER JOIN user_tracking_tags
                ON user_tracking_tags.tag_id = link_tracking_tags.tracking_tag_id
            WHERE 
                (user_links.tweeted = 0 OR user_links.tweeted IS NULL) AND 
                (user_links.retweeted = 0 OR user_links.tweeted IS NULL) AND 
                (user_links.similar = 0 OR user_links.tweeted IS NULL) AND 
                (user_links.discarded = 0 OR user_links.tweeted IS NULL) AND 
                (user_links.favourited = 0 OR user_links.tweeted IS NULL) AND
                (user_links.user_id = ? OR user_links.user_id IS NULL) AND
                user_tracking_tags.user_id = ?
            ORDER BY links.id DESC
            LIMIT 20
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $user_id, $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            while($link = $res->fetch_assoc()) {
                $tweets = $this->get_link_tweets($link['id']);
                $links[] = array('url' => $link['link'], 'id' => $link['id'], 'tweets' => $tweets);
            }

            return $links;
        } else {
            return false;
        }
    }
}