<?php

require_once('../models/account.php');
require_once('../controllers/user-accounts.php');
require_once('../controllers/account-queries.php');
require_once('../helpers/error-response.php');

class Account_Controller {
  private $id = false;
  private $token = false;
  private $secret = false;
  private $username = false;
  private $twitter_id = false;
  private $queries = false;
  private $tweets = array();
  private $cron = '5,35 9,12,16 * * *';

  public function get_cron() {
    return $this->cron;
  }

  public function tweet_if_ready() {
    // TODO
    return error_response(4865098);
  }

  public function get_account_id() {
    return $this->id;
  }

  public function get_account_username() {
    return $this->username;
  }

  public function delete($user, $account_id) {
    $reponse = Account_Model::delete($account_id);

    if ($response) {
      return $user->read();
    }

    return error_response(49865, $reponse);
  }

  public function get_account_queries() {
    $this->queries = new Account_Queries_Controller;
    $this->queries->get_account_queries($this->id);
    return $this->queries;
  }

  public function get_account_queries_array() {
    $this->get_account_queries();
    $queries = $this->queries->get_queries($this->id);

    $array = array();

    foreach ($queries as $query) {
      $array_item = array();
      $array_item['query'] = $query->get_query();
      $array_item['id'] = $query->get_id();
      $array[] = $array_item;
    }

    return $array;
  }

  public function initialise_account($account) {
    $this->id = $account['id'];
    $this->token = $account['token'];
    $this->secret = $account['secret'];
    $this->username = $account['username'];
    $this->cron = $account['cron'];
  }

  public function create($user, $token, $secret, $username, $twitter_id) {
    $account = Account_Model::get_account_by_twitter_id($twitter_id);

    if ($account) {
      $this->initialise_account($account);
    }

    $user_accounts = new User_Accounts_Controller;

    // If the account exists then update it
    if ($this->id) {
      $account = Account_Model::update_account(
        $this->id,
        $token,
        $secret,
        $username
      );

      if (!$account) {
        return error_response(64);
      }

      $this->initialise_account($account);

      if ($user_accounts->user_account_exists($user, $this)) {
        return $user->read(60);
      }

      if (!$user_accounts->create_user_account($user, $this)) {
        return error_response(61);
      }

      return $user->read();
    }

    $account = Account_Model::create_account(
      $token,
      $secret,
      $username,
      $twitter_id,
      $this->cron
    );

    if (!$account) {
      return error_response(62);
    }

    $this->initialise_account($account);

    if (!$user_accounts->create_user_account($user, $this)) {
      return error_response(63);
    }

    return $user->read();
  }
}
