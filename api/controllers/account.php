<?php

require_once('../helpers/success-response.php');
require_once('../models/account.php');

class Account_Controller {
  function delete() {
    success_response();
  }

  function create($user, $token, $secret, $username) {
    if (Account_Model::does_user_account_exist($user->get_user_id(), $username)) {
      return $this->update($user, $token, $secret, $username);
    }

    $created_account = Account_Model::create_user_account(
      $user->get_user_id(),
      $token,
      $secret,
      $username
    );

    if ($created_account) {
      return $user->read();
    }

    return error_response(43);
  }

  function update($user, $token, $secret, $username) {
    $account_updated = Account_Model::update_user_account(
      $user->get_user_id(),
      $token,
      $secret,
      $username
    );

    if ($account_updated) {
      return $user->read();
    }

    return error_response(44);
  }

  function get_accounts($user_id) {
    return Account_Model::get_user_accounts($user_id);
  }
}
