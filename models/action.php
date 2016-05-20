<?php

class Action {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function process_action($action, $id) {
        $_SESSION['id'] = 123;
        
        if(isset($_SESSION['id']) && is_numeric($_SESSION['id'])) {
            switch($action) {
                case 'linkTweeted':
                    return $this->link_tweeted($id, $_SESSION['id']);
                case 'linkSimilar':
                    return $this->link_similar($id, $_SESSION['id']);
                case 'linkDiscard':
                    return $this->discard_link($id, $_SESSION['id']);
                case 'tweetReply':
                    return $this->tweet_replied($id, $_SESSION['id']);
                case 'tweetRetweet':
                    return $this->tweet_retweeted($id, $_SESSION['id']);
                case 'tweetLove':
                    return $this->tweet_loved($id, $_SESSION['id']);
                case 'tweetDiscard':
                    return $this->tweet_discarded($id, $_SESSION['id']);
                case 'removeTag':
                    return $this->remove_tag($id, $_SESSION['id']);
                default:
                    return array('err' => true, 'err' => 'Undefined error');
            }
        } else {
            return array('err' => true, 'err' => 'Bad ID');
        }       
    }

    public function link_tweeted($id, $user) {
        $query = '
            UPDATE links
            SET tweeted = 1
            WHERE id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt) {
            return array('response' => true);
        } else {
            return array('err' => true, 'err' => 'Error');
        }
    }

    public function link_similar($id, $user) {
        $query = '
            UPDATE links
            SET similar = 1
            WHERE id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt) {
            return array('response' => true);
        } else {
            return array('err' => true, 'err' => 'Error');
        }
    }

    public function discard_link($id, $user) {
        $query = '
            UPDATE links
            SET discarded = 1
            WHERE id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt) {
            return array('response' => true);
        } else {
            return array('err' => true, 'err' => 'Error');
        }
    }

    public function tweet_replied($id, $user) {
        $query = '
            UPDATE links
            SET replied = 1
            WHERE id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt) {
            return array('response' => true);
        } else {
            return array('err' => true, 'err' => 'Error');
        }
    }

    public function tweet_retweeted($id, $user) {
        $query = '
            UPDATE links
            SET retweeted = 1
            WHERE id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt) {
            return array('response' => true);
        } else {
            return array('err' => true, 'err' => 'Error');
        }
    }

    public function tweet_loved($id, $user) {
        $query = '
            UPDATE links
            SET favourited = 1
            WHERE id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt) {
            return array('response' => true);
        } else {
            return array('err' => true, 'err' => 'Error');
        }
    }

    public function tweet_discarded($id, $user) {
        return array('response' => true);
    }

    public function remove_tag($id, $user) {
        return array('response' => true);
    }
}
