<?php

require_once('../models/query.php');
require_once('../controllers/account-queries.php');
require_once('../controllers/tweets.php');
require_once('../helpers/error-response.php');

class Query_Controller {
  private $id = false;
  private $query = false;
  private $tweets = array();

  public function update() {

  }

  public function delete() {

  }

  public function get_query() {
    return $this->query;
  }

  public function get_id() {
    return $this->id;
  }

  public function initilise($query) {
    $this->query = $query['query'];
    $this->id = $query['id'];
  }

  public function create($user, $account_id, $value) {
    $query = Query_Model::get_query_by_value($value);

    if ($query) {
      $this->initilise($query);
    }

    $account_queries = new Account_Queries_Controller;

    if ($this->id) {
      if ($account_queries->account_query_exists($user, $this)) {
        return error_response(56);
      }

      if (!$account_queries->create_account_query($account_id, $this)) {
        return error_response(57);
      }

      return $user->read();
    }

    $query = Query_Model::create_query($value);

    if (!$query) {
      return error_response(58);
    }

    $this->initilise($query);

    if (!$account_queries->create_account_query($account_id, $this)) {
      return error_response(59);
    }

    $user->read();
  }

  public function save_new_tweets() {
    $this->tweets = new Tweets_Controller;
    $this->tweets->get_tweets($this);
    $this->tweets->save_tweets();
  }
}
