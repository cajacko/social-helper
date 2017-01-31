<?php

require_once(dirname(__FILE__) . '/../models/account-blacklist.php');
require_once(dirname(__FILE__) . '/../helpers/error-response.php');

class Account_Blacklist_Controller {
  private $id = false;
  private $account_id = false;
  private $query = false;

  public function get_blacklist_queries($account_id) {
    return Account_Blacklist_Model::get_blacklist_queries($account_id);
  }

  public function create($user, $accountId, $query) {
    if(!Account_Blacklist_Model::create($accountId, $query)) {
      return error_response(870597095);
    }

    return $user->read();
  }

  public function delete($user, $id) {
    if(!Account_Blacklist_Model::delete($id)) {
      return error_response(948658);
    }

    return $user->read();
  }

  public function initialise($blacklist_query_data) {
    $this->id = $blacklist_query_data['id'];
    $this->account_id = $blacklist_query_data['account_id'];
    $this->query = $blacklist_query_data['query'];
  }

  public function is_tweet_in_blacklist($tweet) {
    $data = $tweet->get_json();
    $data = json_decode($data);
    $tweet_text = $data->text;

    logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', $this->query);
    logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', $tweet_text);

    if (strpos($tweet_text, $this->query) !== false) {
      logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', '-Blacklist query is in text');
      return true;
    }

    if (substr($this->query, 0, 1) === '@') {
      $username = substr($this->query, 1);
      logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', $username);
      logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', $data->user->screen_name);
      if ($data->user->screen_name == $username) {
        logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', '-Blacklist query is user');
        return true;
      }
    }

    logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', 'Not in this blacklist');

    return false;
  }
}
