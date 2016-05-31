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
    }
}