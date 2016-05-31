<?php

namespace SocialHelper\User;

class User
{
    private $logged_in = false;
    private $db;
    private $config;

    public function __construct($config, $db)
    {
        $this->db = $db;
        $this->config = $config;
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
            $this->logged_in = true;
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
            SELECT twitterId
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

        return true;
    }

    public function updateDetails($tokens = null)
    {
        if ($tokens === null) {
            $error = new \SocialHelper\Error\Error(9);
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
    }
}
