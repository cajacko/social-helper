<?php

function get_error($code) {
  $json = file_get_contents(dirname(__FILE__) . '/../constants/errors.json');
  $json = json_decode($json, true);

  if (!isset($json[$code])) {
    return false;
  }

  if (!isset($json[$code]['status'])) {
    return false;
  }

  if (!isset($json[$code]['message'])) {
    return false;
  }

  $json[$code]['code'] = $code;

  return $json[$code];
}

function error_response($code = 0, $data = false) {
  $error = get_error($code);

  if (!$error) {
    $error = get_error(12);
    $data = array(
      'code' => $code,
      'data' => $data
    );
  }

  $error['data'] = $data;
  $error['error'] = true;
  $status = $error['status'];
  unset($error['status']);

  if (CRON) {
    print_r($error);
    throw new Exception('Uh oh ' . $error['code']);
  }

  header('Content-Type: application/json');
  http_response_code($status);
  echo json_encode($error, JSON_PRETTY_PRINT);

  exit;
}
