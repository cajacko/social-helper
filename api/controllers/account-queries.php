<?php

require_once('../models/account-queries.php');

class Account_Query_Controller {
  private $account = false;
  private $query = false;
  private $id = false;

  public function account_query_exists($account_id, $query) {
    return Account_Queries::account_query_exists(
      $account_id,
      $query->get_query_id()
    );
  }

  public function create_account_query($account_id, $query) {
    return Account_Queries::create_account_query(
      $account_id,
      $query->get_query_id()
    );
  }
}
