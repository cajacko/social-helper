<?php

require_once('../helpers/success-response.php');
require_once('../models/account.php');
require_once('../helpers/error-response.php');

class Account_Controller {
  $id = false;
  $username = false;
  $token = false;
  $secret = false;

  function initialise_account($account) {
    $this->id = $account['id'];
    $this->username = $account['username'];
    $this->secret = $account['secret'];
    $this->token = $account['token'];
  }

  function delete($user, $account_id) {
    $delete_user_account = Account_Model::delete_user_account(
      $user->get_user_id()
      $account_id
    );

    if ($delete_user_account) {
      return $user->read();
    }

    return error_response(45);
  }

  function create($user, $token, $secret, $username) {
    // If the account already exists then add this user to it.
    // If the user account relationship exists then just update the account details
    // If the account does not exist then create the account and the user relationship
    $account = Account_Model::get_account_by_username($username);

    if ($account) {
      $this->initialise_account($account);
    }

    if ($this->id) {
      return $this->update_user_account($user, $token, $secret);
    }

    $account_id = Account_Model::create_account(
      $token,
      $secret,
      $username
    );

    if (!$account_id) {
      return error_response();
    }

    if (!Account_Model::create_user_account($user->get_user_id(), $account_id)) {
      return error_response();
    }

    return $user->read();
  }

  function update_user_account($user, $token, $secret) {
    $user_account = Account_Model::get_user_account(
      $user->get_user_id(),
      $this->id
    );

    if (!$user_account) {
      if (!Account_Model::create_user_account($user->get_user_id(), $account_id)) {
        return error_response();
      }
    }

    return $this->update_account($user, $token, $secret);
  }

  function update_account($user, $token, $secret) {
    $account_updated = Account_Model::update_account(
      $token,
      $secret,
      $this->id
    );

    if ($account_updated) {
      return $user->read();
    }

    return error_response(44);
  }

  function get_accounts($user_id) {
    return Account_Model::get_user_accounts($user_id);
  }

  function does_user_account_exist($user_id, $account_id) {
    return Account_Model::does_user_account_exist($user_id, $account_id);
  }
}
