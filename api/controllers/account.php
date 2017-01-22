<?php

require_once('../helpers/success-response.php');

class Account_Controller {
  function delete() {
    success_response();
  }

  function create() {
    success_response();
  }

  function get_accounts($user_id) {
    return array(
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
    );
  }
}
