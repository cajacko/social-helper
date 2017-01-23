<?php

require_once('../helpers/success-response.php');
require_once('../helpers/error-response.php');
require_once('account.php');
require_once('cron-controller.php');
require_once('token.php');
require_once('../models/user.php');

class User_Controller {
  private $user_id = false;

  function authenticate($auth = false) {
    $token = new Token_Controller;
    $this->user_id = $token->validate_token($auth);
    return $this->user_id;
  }

  function get_user_id() {
    return $this->user_id;
  }

  function read() {
    if (!$this->user_id) {
      return false;
    }

    $data = $this->get_user_data($this->user_id);
    success_response($data);
  }

  function get_user_data($user_id) {
    $cron = new Cron_Controller;
    $cron_string = $cron->get_cron($user_id);

    if (!$cron_string) {
      return error_response(28);
    }

    $accounts = new Account_Controller;
    $accounts_array = $accounts->get_accounts($user_id);

    if ($accounts_array === false) {
      return error_response(29);
    }

    return array(
      'accounts' => $accounts_array,
      'cron' => $cron_string,
      'loggedIn' => true
    );
  }

  function login($email, $password) {
    $user_id = User_Model::get_user_id_by_email($email);

    if (!$user_id) {
      return error_response(24);
    }

    $db_password = User_Model::get_password_by_user_id($user_id);

    if ($db_password !== $password) {
      return error_response(26);
    }

    $token = new Token_Controller;
    $auth = $token->generate_new_token($user_id);

    if (!$auth) {
      return error_response(27);
    }

    $data = $this->get_user_data($user_id);
    $data['auth'] = $auth;

    success_response($data);
  }

  function create($email, $password, $password_confirm) {
    if ($password !== $password_confirm) {
      return error_response(15);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return error_response(16);
    }

    if (User_Model::get_user_by_email($email)) {
      return error_response(17);
    }

    $default_cron = '5,35 9,12,16 * * *';

    if (!User_Model::set_user($email, $password, $default_cron)) {
      return error_response(18);
    }

    return $this->login($email, $password);
  }

  function logout() {
    success_response(array('loggedIn' => false));
  }
}
