<?php

function error_response($status = 500, $code = 0, $message = false, $data = false) {
  header('Content-Type: application/json');
  http_response_code($status);

  echo json_encode(array(
    'code' => $code,
    'message' => $message,
    'data' => $data
  ));

  exit;
}
