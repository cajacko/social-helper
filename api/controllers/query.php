<?php

require_once(dirname(__FILE__) . '/../models/query.php');
require_once(dirname(__FILE__) . '/../controllers/account-queries.php');
require_once(dirname(__FILE__) . '/../controllers/tweets.php');
require_once(dirname(__FILE__) . '/../helpers/error-response.php');

class Query_Controller {
  private $id = false;
  private $query = false;
  private $tweets = array();
  private $last_started_cron = false;
  private $last_ran_cron = false;

  public function delete_floating_rows() {
    Query_Model::delete_floating_rows();
  }

  public function get_last_started_cron() {
    return $this->last_started_cron;
  }

  public function get_last_ran_cron() {
    return $this->last_ran_cron;
  }

  public function set_last_started_cron() {
    Query_Model::set_last_started_cron(date('Y-m-d H:i:s'), $this->id);
  }

  public function set_last_ran_cron() {
    Query_Model::set_last_ran_cron(date('Y-m-d H:i:s'), $this->id);
  }

  public function get_query() {
    return $this->query;
  }

  public function get_id() {
    return $this->id;
  }

  public function set_id($query_id) {
    $this->id = $query_id;
  }

  public function initilise($query) {
    $this->query = $query['query'];
    $this->id = $query['id'];
    $this->last_started_cron = $query['last_started_cron'];
    $this->last_ran_cron = $query['last_ran_cron'];
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
