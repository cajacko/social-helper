<?php

require_once('../helpers/success-response.php');
require_once('../helpers/error-response.php');
require_once('account.php');
require_once('cron.php');
require_once('token.php');
require_once('../models/user.php');

class User_Controller {

  function authenticate($auth = false) {
    // $user = User_Modal->get
    if ($auth == 'doyr498h9ehfo84yh875h9843hj') {
      return true;
    }

    return false;
  }

  function read() {
    success_response();
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

    $cron = new Cron_Controller;
    $cron_string = $cron->get_cron($user_id);

    if (!$cron_string) {
      return error_response(28);
    }

    $accounts = new Account_Controller;
    $accounts_array = $cron->get_accounts($user_id);

    if (!$accounts_array) {
      return error_response(29);
    }

    $data = array(
      'auth' => $auth,
      'cron' => $cron_string,
      'accounts' => $accounts_array,
      'loggedIn' => true
    );

    // $data = array(
    //   'cron' => '5,10,30,55 7,8,9,11,12,13,16,17,18 * * *',
    //   'accounts' => array(
    //     array(
    //       'id' => '3986309467',
    //       'username' => 'charliejackson',
    //       'queries' => array(
    //         array(
    //           'id' => '303876459',
    //           'query' => '#iot'
    //         ),
    //         array(
    //           'id' => '45687876',
    //           'query' => '#smarthome'
    //         ),
    //         array(
    //           'id' => '456635434',
    //           'query' => '#improv'
    //         )
    //       )
    //     )
    //   ),
    //   'loggedIn' => true,
    //   'auth' => 'doyr498h9ehfo84yh875h9843hj'
    // );

    success_response($data);
  }

  function create($email, $password, $password_confirm) {
    if ($password !== $password_confirm) {
      return error_response(15);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return error_response(16);
    }

    // if (User_Model->get_user_by_email($email)) {
    //   return error_response(17);
    // }
    //
    // if (!User_Model->set_user($email, $password)) {
    //   return error_response(18);
    // }

    return $this->login($email, $password);
  }

  function logout() {
    success_response(array('loggedIn' => false));
  }
}
