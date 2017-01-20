<?php

require_once('../helpers/success-response.php');

class Cron_Controller {
  function update() {
    $data = array(
      'cron' => 'hello',
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
      'loggedIn' => true
    );

    success_response($data);
  }
}
