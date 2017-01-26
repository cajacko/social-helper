<?php

// require_once('db.php');
require_once('../helpers/error-response.php');

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter_Model {
  private $app = false;

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
}
