<?php

function success_response($data = false) {
  header('Content-Type: application/json');
  http_response_code(200);

  if (!$data) {
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
      'loggedIn' => true
    );
  }

  echo json_encode($data, JSON_PRETTY_PRINT);
  exit;
}
