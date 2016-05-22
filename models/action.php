<?php

class Action {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function process_action($action, $id) {        
        if(isset($_SESSION['id']) && is_numeric($_SESSION['id'])) {
            switch($action) {
                case 'linkTweeted':
                    return $this->update_link_option('tweeted', $id, $_SESSION['id']);
                case 'linkSimilar':
                    return $this->update_link_option('similar', $id, $_SESSION['id']);
                case 'linkDiscard':
                    return $this->update_link_option('discarded', $id, $_SESSION['id']);
                case 'tweetReply':
                    return $this->update_link_option('replied', $id, $_SESSION['id']);
                case 'tweetRetweet':
                    return $this->update_link_option('retweeted', $id, $_SESSION['id']);
                case 'tweetLove':
                    return $this->update_link_option('favourited', $id, $_SESSION['id']);
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

    public function update_link_option($type, $link_id, $user_id) {
        $query = '
            INSERT INTO user_links (user_id, link_id, ' . $type . ')
            VALUES (?, ?, 1)
        ;';

        // prepare and bin
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $user_id, $link_id);
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
