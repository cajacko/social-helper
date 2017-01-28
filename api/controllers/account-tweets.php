<?php

require_once('../controllers/account-queries.php');
require_once('../models/account-tweets.php');
require_once('../models/account-queries.php');

class Account_Tweets_Controller {
  private $account_id = false;
  private $tweet = false;
  private $account = false;

  public function retweet($query_id) {
    // $retweeted = Account_Tweets_Model::retweet(
    //   $this->tweet->get_tweet_id(),
    //   $this->account->get_token(),
    //   $this->account->get_secret()
    // );

    echo "\n\nQuerd Id: " . $query_id . " Retweet: " . $this->tweet->get_tweet_id() . "\n\n"; return true;
    $retweeted = true;

    if ($retweeted) {
      $response = Account_Tweets_Model::set_account_tweet(
        $this->account->get_account_id(),
        $this->tweet->get_id(),
        $query_id,
        date('Y-m-d H:i:s'),
        0
      );

      if (!$response) {
        return error_response(389740984);
      }

      return true;
    }

    $response = Account_Tweets_Model::set_account_tweet(
      $this->account->get_account_id(),
      $this->tweet->get_id(),
      $query_id,
      date('Y-m-d H:i:s'),
      1
    );

    if (!$response) {
      return error_response(896490840);
    }

    return false;
  }

  public function set_account_id($account_id) {
    $this->account_id = $account_id;
  }

  public function set_account($account) {
    $this->account = $account;
  }

  public function set_tweet($tweet) {
    $this->tweet = $tweet;
  }

  public function get_query_order() {
    $query_ids_by_lowest_count = Account_Tweets_Model::get_query_ids_by_lowest_tweet_count($this->account_id, 10);

    $account_queries = new Account_Queries_Model;
    $queries = $account_queries->get_account_queries($this->account_id);

    $no_tweet_queries = array();

    foreach($queries as $query_data) {
      if (!in_array($query_data['id'], $query_ids_by_lowest_count)) {
        $no_tweet_queries[] = $query_data['id'];
      }
    }

    shuffle($no_tweet_queries);

    foreach($no_tweet_queries as $query_id) {
      array_unshift($query_ids_by_lowest_count, $query_id);
    }

    $query_array = array();

    foreach($query_ids_by_lowest_count as $query_id) {
      $account_query = new Account_Queries_Controller;
      $account_query->set_query($query_id);
      $account_query->set_account($this->account_id);
      $query_array[] = $account_query;
    }

    return $query_array;
  }
}
