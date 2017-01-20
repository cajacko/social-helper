<?php

include_once('../helpers/common.php');
include_once('../helpers/error-response.php');

$path = $_SERVER["REQUEST_URI"];
$path_parts = explode('/', $path);

if (!$path_parts) {
  error_response(1);
}

if (count($path_parts) != 3) {
  error_response(2);
}

$controller = $path_parts[1];
$endpoint = $path_parts[2];

include_once('../controllers/app.php');

$app = new App();

$post_data = file_get_contents('php://input');
$post_data = json_decode($post_data, true);

if (!$post_data) {
  error_response(13);
}

if (!isset($post_data['appAuth'])) {
  error_response(11);
}

if (!$app->authenticate($post_data['appAuth'])) {
  error_response(10);
}

// Unauthenticated endpoints

include_once('../controllers/user.php');
$user = new User;

switch($controller) {
  case 'user':
    switch($endpoint) {
      case 'login':
        $user->login();
        break;

      case 'create':
        $user->create();
        break;
    }

    break;
}

if (!isset($post_data['auth'])) {
  error_response(14);
}

if (!$user->authenticate($post_data['auth'])) {
  error_response(9);
}

// Authenticated endpoints

switch($controller) {
  case 'user':
    switch($endpoint) {
      case 'read':
        $user->read();
        break;

      case 'logout':
        $user->logout();
        break;

      default:
        error_response(4);
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
        error_response(6);
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
        error_response(7);
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
        error_response(8);
    }

    break;

  default:
    error_response(5);
}

error_response(3);
