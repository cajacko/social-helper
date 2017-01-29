<?php

require_once(dirname(__FILE__) . '/../controllers/query.php');
require_once(dirname(__FILE__) . '/../models/queries.php');
require_once(dirname(__FILE__) . '/../helpers/error-response.php');

class Queries_Controller {
  private $queries = array();

  private function get_queries() {
    $queries = Queries_Model::get_queries();

    if (!$queries) {
      return error_response();
    }

    $query_array = array();

    foreach ($queries as $query_data) {
      $query = new Query_controller;
      $query->initilise($query_data);
      $query_array[] = $query;
    }

    $this->queries = $query_array;
  }

  private function should_save_new_tweets($query) {
    $last_started = strtotime($query->get_last_started_cron());
    $last_ran = strtotime($query->get_last_ran_cron());

    if ($last_ran >= $last_started) {
      return true;
    }

    if ($last_started > strtotime('+10 minutes')) {
      return true;
    }

    return false;
  }

  public function save_new_tweets() {
    $this->get_queries();

    foreach ($this->queries as $query) {
      if ($this->should_save_new_tweets($query)) {
        $query->set_last_started_cron();
        $query->save_new_tweets();
        $query->set_last_ran_cron();
      }
    }
  }
}
