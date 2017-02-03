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

  private function is_hashtag_blacklist_query() {
    logger('Account_Blacklist_Controller', 'is_hashtag_blacklist_query', '- Init');

    if (substr($this->query, 0, 1) === '#') {
      logger('Account_Blacklist_Controller', 'is_hashtag_blacklist_query', '- Is a hashtag query');
      return true;
    }

    logger('Account_Blacklist_Controller', 'is_hashtag_blacklist_query', '- Is not a hashtag query');

    return false;
  }

  private function is_user_blacklist_query() {
    logger('Account_Blacklist_Controller', 'is_user_blacklist_query', '- Init');

    if (substr($this->query, 0, 1) === '@') {
      logger('Account_Blacklist_Controller', 'is_user_blacklist_query', '- Is a user query');
      return true;
    }

    logger('Account_Blacklist_Controller', 'is_user_blacklist_query', '- Is not a user query');

    return false;
  }

  private function is_query_in_text($tweet_text) {
    logger('Account_Blacklist_Controller', 'is_query_in_text', '- Init');

    if (strpos(strtolower($tweet_text), strtolower($this->query)) !== false) {
      logger('Account_Blacklist_Controller', 'is_query_in_text', '- query is in text');
      return true;
    }

    logger('Account_Blacklist_Controller', 'is_query_in_text', '- query is not in text');

    return false;
  }

  private function is_text_in_regex($tweet_text) {
    logger('Account_Blacklist_Controller', 'is_text_in_regex', '- Init');
    $match = preg_match($this->query, $tweet_text);

    if ($match === 1) {
      logger('Account_Blacklist_Controller', 'is_text_in_regex', '- Regex Matched');
      return true;
    }

    if ($match === false) {
      logger('Account_Blacklist_Controller', 'is_text_in_regex', '- Regex failed!!');
    }

    logger('Account_Blacklist_Controller', 'is_text_in_regex', '- Regex did not match');

    return false;
  }

  public function is_tweet_in_blacklist($tweet) {
    $data = $tweet->get_json();
    $data = json_decode($data);
    $tweet_text = $data->text;

    logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', $this->query);
    logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', $tweet_text);

    if ($this->is_hashtag_blacklist_query()) {
      if ($this->is_query_in_text($tweet_text)) {
        logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', '-Blacklist hashtag query is in text');
        return true;
      }

      logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', '-Blacklist hashtag query is not in text');

      return false;
    }

    if ($this->is_user_blacklist_query()) {
      $username = substr($this->query, 1);
      logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', $username);
      logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', $data->user->screen_name);
      if (strtolower($data->user->screen_name) == $username) {
        logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', '-Blacklist query is user');
        return true;
      }

      if ($this->is_query_in_text($tweet_text)) {
        logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', '- Blacklist user query is in text');
        return true;
      }

      logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', '- Blacklist user query is not in text or the author');

      return false;
    }

    if ($this->is_text_in_regex($tweet_text)) {
      logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', '- Blacklist text matches regex query');
      return true;
    }

    logger('Account_Blacklist_Controller', 'is_tweet_in_blacklist', 'Not in this blacklist');

    return false;
  }
}
