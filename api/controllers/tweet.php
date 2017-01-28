<?php

require_once('../controllers/tweet-query.php');
require_once('../models/tweet.php');
require_once('../helpers/error-response.php');

class Tweet_Controller {
  private $json = false;
  private $tweet_id = false;
  private $created = false;
  private $retweets = false;
  private $favourites = false;
  private $user_id = false;
  public $query = false;
  private $data = false;
  private $id = false;

  function __construct() {
    $this->query = new Tweet_Query;
  }

  public function get_id() {
    return $this->id;
  }

  public function initialise($tweet_data, $query) {
    $this->data = $tweet_data;
    $this->json = json_encode($tweet_data);
    $this->tweet_id = $tweet_data->id_str;
    $this->created = date('Y-m-d H:i:s', strtotime($tweet_data->created_at));
    $this->retweets = $tweet_data->retweet_count;
    $this->favourites = $tweet_data->favorite_count;
    $this->user_id = $tweet_data->user->id_str;
    $this->query->set_query($query);
    $this->query->set_tweet($this);
  }

  public function exists() {
    $row = Tweet_Model::tweet_exists($this->tweet_id);

    if ($row && $row['id']) {
      $this->id = $row['id'];
      $this->query->set_tweet($this);
      return true;
    }

    return error_response(89475);
  }

  public function update() {
    return Tweet_Model::update(
      $this->tweet_id,
      $this->created,
      $this->retweets,
      $this->favourites,
      $this->user_id,
      $this->json
    );
  }

  public function create() {
    $row = Tweet_Model::create(
      $this->tweet_id,
      $this->created,
      $this->retweets,
      $this->favourites,
      $this->user_id,
      $this->json
    );

    if ($row && $row['id']) {
      $this->id = $row['id'];
      $this->query->set_tweet($this);
      return true;
    }

    return error_response(39864);
  }
}
