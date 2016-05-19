<?php

class User {
    private $db;
    private $twitter;

    public function __construct($db, $twitter) {
        $this->db = $db;
        $this->twitter = $twitter;
    }

    public function login_user() {
        $twitter_user = $this->twitter->get_twitter_user();

        if($twitter_user) {
            return $twitter_user;
        } else {
            return false;
        }
    }

    public function get_user_by_twitter_id($twitter_id) {
        $query = '
            SELECT users.id
            FROM users
            WHERE users.twitterId = ?
            LIMIT 1
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $twitter_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            $user = $res->fetch_assoc();
            return $user;
        } else {
            return false;
        }
    }

    public function register_user($twitter_id, $token, $secret) {
        $query = '
            INSERT INTO users (twitterId, token, secret)
            VALUES (?, ?, ?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $twitter_id, $token, $secret);
        $stmt->execute();

        if($stmt->insert_id) {
            return array('id' => $stmt->insert_id);
        } else {
            return false;
        }
    }

    public function is_user_logged_in() {
        if(isset($_SESSION['id'], $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'])) {
            return true;
        } else {
            return false;
        }
    }
}
