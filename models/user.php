<?php

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($twitter_id, $token, $secret) {
        $query = '
            INSERT INTO users (twitterId, token, secret)
            VALUES (?, ?, ?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $twitter_id, $token, $secret);
        $stmt->execute();

        if($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function is_user_logged_in() {
        if(isset($_SESSION['id'], $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'])) {
            // TODO: make call to twitter to check tokens are valid
            return true;
        } else {
            return false;
        }
    }

    public function does_user_exist($twitter_id) {
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
            return $user['id'];
        } else {
            return false;
        }
    }

    public function update_tokens($user_id, $oauth_token, $oauth_token_secret) {
        $query = '
            UPDATE users
            SET token = ?, secret = ?
            WHERE id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssi", $oauth_token, $oauth_token_secret, $user_id);
        $stmt->execute();

        if($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function login($user_id, $oauth_token, $oauth_token_secret) {
        $_SESSION['id'] = $user_id;
        $_SESSION['oauth_token'] = $oauth_token;
        $_SESSION['oauth_token_secret'] = $oauth_token_secret;
        return true;
    }
}
