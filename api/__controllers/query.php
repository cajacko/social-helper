<?php

require_once('../helpers/success-response.php');

class Query_Controller {
  function does_user_account_exist($user, $account_id) {
    $account = new Account();
    return $account->does_user_account_exist($user, $account_id);
  }

  function update($user, $account_id, $query_id, $query) {
    if (!$this->does_user_account_exist($user, $account_id)) {
      return error_response();
    }

    if(Query_Model::update_account_query($account_id, $query)) {
      return $user->read();
    }

    return error_response();
  }

  function delete($user, $account_id, $query_id) {
    if (!$this->does_user_account_exist($user, $account_id)) {
      return error_response();
    }

    if(Query_Model::delete_account_query($account_id, $query_id)) {
      return $user->read();
    }

    return error_response();
  }

  function create($user, $account_id, $query) {
    if (Query_Model::does_query_exist()) {
      return error_response();
    }

    if(Query_Model::create_account_query($account_id, $query)) {
      return $user->read();
    }

    return error_response();
  }
}
