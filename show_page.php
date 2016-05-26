<?php

function get_top_links($user_id) {
    $query = '
        SELECT *
        FROM links
        INNER JOIN link_user_rating
            ON links.id = link_user_rating.link_id
        WHERE 
            link_user_rating.user_id = ?
        ORDER BY link_user_rating.rating DESC
        LIMIT ?, ?
    ';

    if($result) {
        return $result;
    } else {
        return false;
    }
}

class User {
    private $logged_in;
    private $id;
    private $session_vars = array(
        'user_id' => 'user_id',
    );

    private function set_user_vars($user) {
        $this->id = $user['id'];
    }

    private function is_user_logged_in() {
        if(!isset($_SESSION[$session_vars['user_id']])) {
            return false;
        }

        if(is_numeric($_SESSION[$session_vars['user_id']])) {
            return false;
        }

        $query = '
            SELECT *
            FROM users 
            WHERE id = ?
            LIMIT 1
        ';

        if($result) {
            $this->set_user_vars($result);
            return true;
        }
            
        return false;
    }

    public function __construct() {
        $this->is_user_logged_in();
    }
}

function show_page() {
    $user = new User;

    if(!$user->logged_in) {
        return false;
    } 

    if(!$user->id) {
        return false;
    } 

    if(!is_numeric($user->id)) {
        return false;
    }

    $top_links = get_top_links($user->id);

    if($top_links) {
        return $top_links;
    }

    return false;
}

print show_page();

// TODO: Have a new 
