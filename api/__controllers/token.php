<?php

require_once('../models/token.php');
require_once('../helpers/error-response.php');

class Token_Controller {
  function generate_new_token($user_id) {
    $token = bin2hex(random_bytes(20));
    $expires = date('Y-m-d H:i:s', time() + 7200);

    if (Token_Model::set_user_token($user_id, $token, $expires)) {
      return $token;
    }

    return false;
  }

  function validate_token($token) {
    if (!$token) {
      return false;
    }

    $db_token = Token_Model::get_token($token);

    if (!$db_token) {
      return false;
    }

    if (!$db_token['user_id']) {
      return false;
    }

    if (!$db_token['expires']) {
      return false;
    }

    if (new DateTime() > new DateTime($db_token['expires'])) {
      return false;
    }

    return $db_token['user_id'];
  }
}
