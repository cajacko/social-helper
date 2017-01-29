<?php

require_once(dirname(__FILE__) . '/../models/user-tokens.php');

class User_Tokens_Controller {
  private $id = false;
  private $user = false;
  private $token = false;

  public function get_user_by_token($token) {
    $user = User_Tokens_Model::get_user_by_token($token);
    return $user;
  }

  public function generate_new_token($user_id) {
    $token = bin2hex(random_bytes(20));
    $expires = date('Y-m-d H:i:s', time() + 7200);

    if (!User_Tokens_Model::set_user_token($user_id, $token, $expires)) {
      return false;
    }

    $this->token = $token;
    return $this->token;
  }

  public function delete_user_token($token, $user_id) {
    return false;
  }
}
