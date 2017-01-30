<?php

// require_once('db.php');
require_once(dirname(__FILE__) . '/../helpers/error-response.php');

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter_Model {
  private $app = false;
  private $user = false;

  public function initialise_app() {
    $app = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    $this->app = $app;
  }

  public function get_tweets_by_query($query) {
    $endpoint = 'search/tweets';
    $params = array(
      'count' => 100,
      'exclude_replies' => true,
      'q' => $query,
      'result_type' => 'mixed' // mixed, recent or popular
    );

    $tweets = $this->app->get($endpoint, $params);

    if (!$tweets->statuses) {
      return error_response(5864);
    }

    return $tweets->statuses;
  }

  public function retweet($tweet_id) {
    $endpoint = 'statuses/retweet';

    $params = array(
      'id' => $tweet_id
    );

    $response = $this->user->post($endpoint, $params);

    print_r($response);

    if ($response->errors) {
      return false;
    }

    if (!$response->id_str) {
      return error_response(398659084);
    }

    return true;
  }

  public function initialise_user($token, $secret) {
    $user = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $token, $secret);
    $this->user = $user;
  }
}
