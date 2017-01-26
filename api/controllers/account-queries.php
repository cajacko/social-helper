<?php

require_once('../models/account-queries.php');
require_once('../controllers/query.php');

class Account_Queries_Controller {
  private $account = false;
  private $query = false;
  private $id = false;
  private $queries = array();

  public function get_queries() {
    return $this->queries;
  }

  public function get_account_queries($account_id) {
    $queries = Account_Queries_Model::get_account_queries($account_id);
    $array = array();

    foreach($queries as $query_data) {
      $query = new Query_Controller;
      $query->initilise($query_data);
      $array[] = $query;
    }

    $this->queries = $array;
  }

  public function account_query_exists($account_id, $query) {
    return Account_Queries_Model::account_query_exists(
      $account_id,
      $query->get_query_id()
    );
  }

  public function create_account_query($account_id, $query) {
    return Account_Queries_Model::create_account_query(
      $account_id,
      $query->get_query_id()
    );
  }
}
