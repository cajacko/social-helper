<?php

namespace SocialHelper\User;

class User
{
    private $logged_in = false;
    private $db;
    private $config;
    private $user_id = false;

    public function __construct($config, $db)
    {
        $this->db = $db;
        $this->config = $config;
    }

    private function returnIsLoggedIn()
    {
        if (!isset($_SESSION['loggedIn'])) {
            return false;
        }

        if (!$_SESSION['loggedIn']) {
            return false;
        }

        if (!isset($_SESSION['userId'])) {
            return false;
        }

        if (!is_numeric($_SESSION['userId'])) {
            return false;
        }

        return true;
    }

    public function isLoggedIn()
    {
        if ($this->returnIsLoggedIn()) {
            $this->logged_in = true;
            $this->user_id = $_SESSION['userId'];
        } else {
            $this->logged_in = false;
        }

        return $this->logged_in;
    }

    public function isRegistered($twitter_id = null)
    {
        if ($twitter_id === null) {
            $error = new \SocialHelper\Error\Error(7);
            $error = $error->getError();
            return $error;
        }

        $query = '
            SELECT id, twitterId
            FROM users
            WHERE twitterId = ?
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $twitter_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if (!$res->num_rows) {
            return false;
        }

        if (!$res->num_rows > 1) {
            $error = new \SocialHelper\Error\Error(8);
            $error = $error->getError();
            return $error;
        }

        $row = $res->fetch_assoc();

        if (isset($row['id']) && is_numeric($row['id'])) {
            $this->user_id = $row['id'];
        } else {
            $error = new \SocialHelper\Error\Error(19);
            $error = $error->getError();
            return $error;
        }

        return true;
    }

    public function updateDetails($tokens = null)
    {
        if ($tokens === null) {
            $error = new \SocialHelper\Error\Error(9);
            $error = $error->getError();
            return $error;
        }

        if (!isset($tokens['user_id'])) {
            $error = new \SocialHelper\Error\Error(15);
            $error = $error->getError();
            return $error;
        }

        if (!isset($tokens['oauth_token'])) {
            $error = new \SocialHelper\Error\Error(16);
            $error = $error->getError();
            return $error;
        }

        if (!isset($tokens['oauth_token_secret'])) {
            $error = new \SocialHelper\Error\Error(17);
            $error = $error->getError();
            return $error;
        }

        $query = '
            UPDATE users
            SET token = ?, secret = ?
            WHERE twitterId = ?
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $token, $secret, $twitter_id);
        $token = $tokens['oauth_token'];
        $secret = $tokens['oauth_token_secret'];
        $twitter_id = $tokens['user_id'];

        if ($stmt->execute()) {
            return true;
        } else {
            $error = new \SocialHelper\Error\Error(10);
            $error = $error->getError();
            return $error;
        }
    }

    public function login()
    {
        $_SESSION['loggedIn'] = true;
        $_SESSION['userId'] = $this->user_id;
    }

    public function register($tokens = null)
    {
        if ($tokens === null) {
            $error = new \SocialHelper\Error\Error(11);
            $error = $error->getError();
            return $error;
        }

        if (!isset($tokens['user_id'])) {
            $error = new \SocialHelper\Error\Error(12);
            $error = $error->getError();
            return $error;
        }

        if (!isset($tokens['oauth_token'])) {
            $error = new \SocialHelper\Error\Error(13);
            $error = $error->getError();
            return $error;
        }

        if (!isset($tokens['oauth_token_secret'])) {
            $error = new \SocialHelper\Error\Error(14);
            $error = $error->getError();
            return $error;
        }

        $query = '
            INSERT INTO users (twitterId, token, secret)
            VALUES (?, ?, ?)
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $twitter_id, $token, $secret);
        $token = $tokens['oauth_token'];
        $secret = $tokens['oauth_token_secret'];
        $twitter_id = $tokens['user_id'];

        if ($stmt->execute()) {
            $this->user_id = $stmt->insert_id;
            return true;
        } else {
            $error = new \SocialHelper\Error\Error(18);
            $error = $error->getError();
            return $error;
        }
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}
