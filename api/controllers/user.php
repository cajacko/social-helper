<?php

include_once('../helpers/success-response.php');

class User {
  function authenticate($auth = false) {
    if ($auth == 'doyr498h9ehfo84yh875h9843hj') {
      return true;
    }

    return false;
  }

  function read() {
    success_response();
  }

  function login() {
    $data = array(
      'cron' => '5,10,30,55 7,8,9,11,12,13,16,17,18 * * *',
      'accounts' => array(
        array(
          'id' => '3986309467',
          'username' => 'charliejackson',
          'queries' => array(
            array(
              'id' => '303876459',
              'query' => '#iot'
            ),
            array(
              'id' => '45687876',
              'query' => '#smarthome'
            ),
            array(
              'id' => '456635434',
              'query' => '#improv'
            )
          )
        )
      ),
      'loggedIn' => true,
      'auth' => 'doyr498h9ehfo84yh875h9843hj'
    );

    success_response($data);
  }

  function create() {
    success_response();
  }

  function logout() {
    success_response(array('loggedIn' => false));
  }
}
