<?php

require_once('../models/user-accounts.php');

class User_Accounts_Controller {
  private $id = false;
  private $user = false;
  private $account = false;
  private $accounts = array();

  public function get_accounts_by_user_id($user_id) {
    $accounts = User_Accounts_Model::get_accounts_by_user_id($user_id);

    if ($accounts) {
      $this->accounts = $accounts;
    }

    return $this->accounts;
  }
}
