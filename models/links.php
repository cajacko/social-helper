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
            SELECT tweet_links.link, tweet_links.tweet_id
            FROM tweets
            INNER JOIN tweet_links
                ON tweets.id = tweet_links.tweet_id
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            while($link = $res->fetch_assoc()) {
                $links[] = array('tweet_id' => $link['tweet_id'], 'link' => $link['link']);
            }

            return $links;
        } else {
            return false;
        }
    }

    public function resolve_url($link) {
        return $link;
    }

    public function save_link($link) {
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

    public function process_links() {
        $links = $this->get_links();

        foreach($links as $link) {
            $resolved_url = $this->resolve_url($link['link']);
            $link_id = $this->save_link($link['link']);
            $this->save_link_tweet($link_id, $link['tweet_id']);
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

    public function get_top_links() {
        $links = array();

        $query = '
            SELECT *
            FROM links
            ORDER BY id
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
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