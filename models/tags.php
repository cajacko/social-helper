<?php

class Tags {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function get_all_tags() {
        $tags = array();

        $query = '
            SELECT tag, id
            FROM userTrackingTags
            GROUP BY tag
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            while($tag = $res->fetch_assoc()) {
                $tags[] = array('tag' => $tag['tag'], 'id' => $tag['id']);
            }

            return $tags;
        } else {
            return false;
        }
    }

    public function get_user_tags() {
        $tags = array();

        $query = '
            SELECT tracking_tags.tag, user_tracking_tags.id
            FROM user_tracking_tags
            INNER JOIN tracking_tags
                ON user_tracking_tags.tag_id = tracking_tags.id
            WHERE user_tracking_tags.user_id = ?
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $_SESSION['id']);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows) {
            while($tag = $res->fetch_assoc()) {
                $tags[] = array('tag' => $tag['tag'], 'id' => $tag['id']);
            }

            return $tags;
        } else {
            return false;
        }
    }

    public function delete_tracking_tag() {

    }

    public function delete_user_tag($tag_id) {
        if(isset($_SESSION['id'])) {
            // If this is the only user with this tag then delete the whole tag
            $query = '
                DELETE FROM user_tracking_tags
                WHERE id = ? AND user_id = ?
            ;';

            // prepare and bind
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $tag_id, $_SESSION['id']);
            $stmt->execute();

            if($stmt) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function does_tracking_tag_exist($tag) {

    }

    public function add_tracking_tag($tag) {
        $query = '
            INSERT INTO tracking_tags (tag)
            VALUES (?)
        ;';

        // prepare and bind
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $tag);
        $stmt->execute();

        if($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function add_user_tags($tag) {
        if(isset($_SESSION['id'])) {
            $tracking_tag_id = $this->does_tracking_tag_exist($tag);

            if(!$tracking_tag_id) {
                $tracking_tag_id = $this->add_tracking_tag($tag);
            }

            $query = '
                INSERT INTO user_tracking_tags (user_id, tag_id)
                VALUES (?, ?)
            ;';

            // prepare and bind
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $_SESSION['id'], $tracking_tag_id);
            $stmt->execute();

            if($stmt->insert_id) {
                return $stmt->insert_id;
            } else {
                return false;
            }
        } else {
            return false;
        }   
    }
}