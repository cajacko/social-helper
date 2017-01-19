<?php

include_once('../helpers/error-response.php');

$path = $_SERVER["REQUEST_URI"];
$path_parts = explode('/', $path);

if (!$path_parts) {
  error_response(404, 1, 'No endpoint specified');
}

if (count($path_parts) != 3) {
  error_response(404, 2, 'Bad endpoint supplied');
}

$controller = $path_parts[1];
$endpoint = $path_parts[2];

switch($controller) {
  case 'user':
    include_once('../controllers/user.php');
    $user = new User;

    switch($endpoint) {
      case 'read':
        $user->read();
        break;

      case 'login':
        $user->login();
        break;

      case 'logout':
        $user->logout();
        break;

      case 'create':
        $user->create();
        break;

      default:
        error_response(404, 4, 'No endpoint');
    }

    break;

  case 'account':
    include_once('../controllers/account.php');
    $account = new Account;

    switch($endpoint) {
      case 'delete':
        $account->delete();
        break;

      case 'create':
        $account->create();
        break;

      default:
        error_response(404, 6, 'No endpoint');
    }

    break;

  case 'cron':
    include_once('../controllers/cron.php');
    $cron = new Cron;

    switch($endpoint) {
      case 'update':
        $cron->update();
        break;

      default:
        error_response(404, 7, 'No endpoint');
    }

    break;

  case 'query':
    include_once('../controllers/query.php');
    $query = new Query;

    switch($endpoint) {
      case 'update':
        $query->update();
        break;

      case 'delete':
        $query->delete();
        break;

      case 'create':
        $query->create();
        break;

      default:
        error_response(404, 8, 'No endpoint');
    }

    break;

  default:
    error_response(404, 5, 'No controller');
}

error_response(500, 3, 'No response has been sent');
