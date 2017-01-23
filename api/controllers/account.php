<?php

require_once('../helpers/success-response.php');
require_once('../models/account.php');

class Account_Controller {
  function delete() {
    success_response();
  }

  function create() {
    success_response();
  }

  function get_accounts($user_id) {
    return Account_Model::get_user_accounts($user_id);
  }
}
