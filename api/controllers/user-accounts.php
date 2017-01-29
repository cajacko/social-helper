<?php

require_once(dirname(__FILE__) . '/../models/user-accounts.php');
require_once(dirname(__FILE__) . '/../controllers/account.php');

class User_Accounts_Controller {
  private $id = false;
  private $user = false;
  private $account = false;
  private $accounts = array();

  public function get_accounts_by_user_id($user_id) {
    $accounts = User_Accounts_Model::get_accounts_by_user_id($user_id);

    if ($accounts) {
      foreach($accounts as $account_data) {
        $account = new Account_Controller;
        $account->initialise_account($account_data);

        $this->accounts[] = $account;
      }
    }

    return $this->accounts;
  }

  public function get_accounts_array() {
    $accounts = array();

    foreach($this->accounts as $account) {
      $account_array = array();
      $account_array['id'] = $account->get_account_id();
      $account_array['username'] = $account->get_account_username();
      $account_array['queries'] = $account->get_account_queries_array();
      $account_array['cron'] = $account->get_cron();
      $accounts[] = $account_array;
    }

    return $accounts;
  }

  public function user_account_exists($user, $account) {
    return User_Accounts_Model::user_account_exists(
      $user->get_user_id(),
      $account->get_account_id()
    );
  }

  public function create_user_account($user, $account) {
    return User_Accounts_Model::create_user_account(
      $user->get_user_id(),
      $account->get_account_id()
    );
  }
}
