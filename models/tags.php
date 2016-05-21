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
            SELECT tag, id
            FROM userTrackingTags
            WHERE userId = ?
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

    public function delete_user_tag($tag_id) {
        if(isset($_SESSION['id'])) {
            $query = '
                DELETE FROM userTrackingTags
                WHERE id = ? AND userId = ?
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

    public function add_user_tags($tag) {
        if(isset($_SESSION['id'])) {
            $query = '
                INSERT INTO userTrackingTags (userId, tag)
                VALUES (?, ?)
            ;';

            // prepare and bind
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("is", $_SESSION['id'], $tag);
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