<?php 

function set_user_session($data) {
    foreach($data as $key => $value) {
        $_SESSION[$key] = $value;
    }
}
