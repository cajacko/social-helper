<?php

define('CRON', true);

/*

for each query
  get tweets (Be smart about getting latest, pagination)

  for each tweet
    if tweet exists
      update tweet details

      if tweet_query does not exist
        create tweet query
    else
      create tweet details
      create tweet query

*/

require_once('../helpers/common.php');
require_once('../controllers/queries.php');

$queries = new Queries_Controller;
$queries->save_new_tweets();
