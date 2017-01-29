<?php

require_once('../controllers/account.php');
require_once('../models/accounts.php');
require_once('../helpers/error-response.php');

class Accounts_Controller {
  private $accounts = array();

  private function get_accounts() {
    $accounts = Accounts_Model::get_accounts();

    if (!$accounts) {
      return error_response(9863);
    }

    $accounts_array = array();

    foreach ($accounts as $account_data) {
      $account = new Account_Controller;
      $account->initialise_account($account_data);
      $accounts_array[] = $account;
    }

    $this->accounts = $accounts_array;
  }

  public function tweet_from_accounts() {
    $this->get_accounts();

    foreach ($this->accounts as $account) {
      $account->set_last_started_cron();
      $account->tweet_if_ready();
      $account->set_last_ran_cron();
    }
  }
}
