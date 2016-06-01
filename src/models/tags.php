<?php

namespace SocialHelper\Tags;

class Tag
{
    private $db;
    private $config;

    public function __construct($config, $db)
    {
        $this->db = $db;
        $this->config = $config;
    }

    private function addTagError($message)
    {
        return array(
            'error' => true,
            'error_message' => $message
        );
    }

    private function isTagFormatValid($tag)
    {
        $tag = '#' . $tag;
        return preg_match('/^(?=.{2,140}$)(#|\x{ff03}){1}([0-9_\p{L}]*[_\p{L}][0-9_\p{L}]*)$/u', $tag);
    }

    private function doesUserTagExist($tag, $user_id)
    {
        $query = '
            SELECT *
            FROM twitter_hashtags
            INNER JOIN twitter_hashtags_users
                ON twitter_hashtags.id = twitter_hashtags_users.twitter_hashtag_id
            WHERE twitter_hashtags.tag = ? AND twitter_hashtags_users.user_id = ?
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $tag, $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if (!$res->num_rows) {
            return false;
        }

        if (!$res->num_rows > 1) {
            $error = new \SocialHelper\Error\Error(0);
            $error = $error->getError();
            return $error;
        }

        return true;
    }

    private function getTagId($tag)
    {
        $query = '
            SELECT *
            FROM twitter_hashtags
            WHERE tag = ?
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $tag);
        $stmt->execute();
        $res = $stmt->get_result();

        if (!$res->num_rows) {
            return false;
        }

        if (!$res->num_rows > 1) {
            $error = new \SocialHelper\Error\Error(0);
            $error = $error->getError();
            return $error;
        }

        $row = $res->fetch_assoc();

        if (isset($row['id']) && is_numeric($row['id'])) {
            return $row['id'];
        } else {
            $error = new \SocialHelper\Error\Error(0);
            $error = $error->getError();
            return $error;
        }
    }

    private function insertTag($tag)
    {
        $query = '
            INSERT INTO twitter_hashtags (tag)
            VALUES (?)
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $tag);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            $error = new \SocialHelper\Error\Error(0);
            $error = $error->getError();
            return $error;
        }
    }

    private function addTagUserAssociation($tag_id, $user_id)
    {
        $query = '
            INSERT INTO twitter_hashtags_users (twitter_hashtag_id, user_id)
            VALUES (?, ?)
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $tag_id, $user_id);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            $error = new \SocialHelper\Error\Error(0);
            $error = $error->getError();
            return $error;
        }
    }

    public function addTag($user = null)
    {
        if (!isset($_POST['tag'])) {
            return $this->addTagError('Tag was not set');
        }

        $tag = $_POST['tag'];

        if ('' == $tag) {
            return $this->addTagError('Tag is empty');
        }

        if ($user === null) {
            return $this->addTagError('User was not set');
        }

        if (!$user->isLoggedIn()) {
            return $this->addTagError('User is not logged in');
        }

        $user_id = $user->getUserId();

        if (!$user_id) {
            return $this->addTagError('Could not get user ID');
        }

        if (!$this->isTagFormatValid($tag)) {
            return $this->addTagError('Tag is not in a valid format');
        }

        $response = $this->doesUserTagExist($tag, $user_id);

        if (isset($response['error'])) {
            return $this->addTagError('Error checking if the tag association already exists');
        }

        if ($response) {
            return $this->addTagError('Tag already exists');
        }

        $tag_id = $this->getTagId($tag);

        if (isset($tag_id['error'])) {
            return $this->addTagError('Error getting tag id');
        }

        if (!$tag_id) {
            $tag_id = $this->insertTag($tag);

            if (isset($tag_id['error'])) {
                return $this->addTagError('Error saving new tag');
            }
        }

        $response = $this->addTagUserAssociation($tag_id, $user_id);

        if (isset($response['error'])) {
            return $this->addTagError('Error saving the tag/user association');
        }

        if (!$response) {
            return $this->addTagError('Error saving the tag/user association');
        }

        return array(
            'error' => false,
            'success' => true,
            'tagId' => $tag_id
        );
    }

    public function getUserTags($user_id)
    {
        $query = '
            SELECT twitter_hashtags.tag, twitter_hashtags.id
            FROM twitter_hashtags
            INNER JOIN twitter_hashtags_users
                ON twitter_hashtags.id = twitter_hashtags_users.twitter_hashtag_id
            WHERE twitter_hashtags_users.user_id = ?
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if (!$res->num_rows) {
            return false;
        }

        $tags = array();

        while ($row = $res->fetch_assoc()) {
            $tags[] = array(
                'id' => $row['id'],
                'tag' => $row['tag']
            );
        }

        return $tags;
    }
}
