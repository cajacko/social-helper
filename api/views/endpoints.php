<?php

define('CRON', false);

require_once(dirname(__FILE__) . '/../helpers/common.php');
require_once(dirname(__FILE__) . '/../helpers/error-response.php');

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

require_once(dirname(__FILE__) . '/../controllers/app.php');

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

require_once(dirname(__FILE__) . '/../controllers/user.php');
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
    require_once(dirname(__FILE__) . '/../controllers/account.php');
    $account = new Account_Controller;

    switch($endpoint) {
      case 'delete':
        if (!isset($post_data['id'])) {
          error_response(40);
        }

        $account->delete($user, $post_data['id']);
        break;

      case 'create':
        if (!isset($post_data['username'])) {
          error_response(40);
        }

        if (!isset($post_data['twitter_id'])) {
          error_response(9857);
        }

        if (!isset($post_data['accessToken'])) {
          error_response(41);
        }

        if (!isset($post_data['accessTokenSecret'])) {
          error_response(42);
        }

        $account->create(
          $user,
          $post_data['accessToken'],
          $post_data['accessTokenSecret'],
          $post_data['username'],
          $post_data['twitter_id']
        );

        break;

      default:
        error_response(6);
    }

    break;

  case 'cron':
    require_once(dirname(__FILE__) . '/../controllers/cron.php');
    $cron = new Cron_Controller;

    switch($endpoint) {
      case 'update':
        if (!isset($post_data['cron'])) {
          error_response(37);
        }

        if (!isset($post_data['accountId'])) {
          error_response(38649);
        }

        $cron->update($user, $post_data['accountId'], $post_data['cron']);
        break;

      default:
        error_response(7);
    }

    break;

  case 'query':
    require_once(dirname(__FILE__) . '/../controllers/query.php');
    $query = new Query_Controller;

    require_once(dirname(__FILE__) . '/../controllers/account-queries.php');
    $account_queries = new Account_Queries_Controller;

    switch($endpoint) {
      case 'delete':
        if (!isset($post_data['accountId'])) {
          error_response(65);
        }

        if (!isset($post_data['queryId'])) {
          error_response(66);
        }

        $account_queries->delete(
          $user,
          $post_data['accountId'],
          $post_data['queryId']
        );

        break;

      case 'create':
        if (!isset($post_data['accountId'])) {
          error_response(65);
        }

        if (!isset($post_data['query'])) {
          error_response(67);
        }

        $query->create(
          $user,
          $post_data['accountId'],
          $post_data['query']
        );
        break;

      default:
        error_response(8);
    }

    break;

  case 'blacklist':
    require_once(dirname(__FILE__) . '/../controllers/account-blacklist.php');
    $account_blacklist = new Account_Blacklist_Controller;

    switch($endpoint) {
      case 'delete':
        if (!isset($post_data['id'])) {
          error_response(3986);
        }

        $account_blacklist->delete(
          $user,
          $post_data['id']
        );

        break;

      case 'create':
        if (!isset($post_data['accountId'])) {
          error_response(45333);
        }

        if (!isset($post_data['query'])) {
          error_response(22466);
        }

        $account_blacklist->create(
          $user,
          $post_data['accountId'],
          $post_data['query']
        );
        break;

      default:
        error_response(30987098);
    }

    break;

  default:
    error_response(5);
}

error_response(3);
