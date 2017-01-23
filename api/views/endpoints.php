<?php

require_once('../helpers/common.php');
require_once('../helpers/error-response.php');

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

require_once('../controllers/app.php');

$app = new App_Controller();

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

require_once('../controllers/user.php');
$user = new User_Controller;

switch($controller) {
  case 'user':
    switch($endpoint) {
      case 'login':
        if (!isset($post_data['email'])) {
          error_response(19);
        }

        if (!isset($post_data['password'])) {
          error_response(20);
        }

        $user->login($post_data['email'], $post_data['password']);
        break;

      case 'create':
        if (!isset($post_data['email'])) {
          error_response(21);
        }

        if (!isset($post_data['password'])) {
          error_response(22);
        }

        if (!isset($post_data['passwordConfirm'])) {
          error_response(23);
        }

        $user->create($post_data['email'], $post_data['password'], $post_data['passwordConfirm']);
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
    require_once('../controllers/account.php');
    $account = new Account_Controller;

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
    require_once('../controllers/cron.php');
    $cron = new Cron_Controller;

    switch($endpoint) {
      case 'update':
        $cron->update();
        break;

      default:
        error_response(7);
    }

    break;

  case 'query':
    require_once('../controllers/query.php');
    $query = new Query_Controller;

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
