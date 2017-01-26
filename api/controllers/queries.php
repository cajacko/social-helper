<?php

require_once('../controllers/query.php');
require_once('../models/queries.php');
require_once('../helpers/error-response.php');

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

  public function save_new_tweets() {
    $this->get_queries();

    foreach ($this->queries as $query) {
      $query->save_new_tweets();
    }
  }
}
