<?php

define('CRON', true);

/*

get accounts

for each account
  get cron

  if it is not time to tweet according to cron
    break

  get last 100 tweets we sent with their respective queries
  queryOrder = generate query preference order (array of queries, ordered by which one to try and tweet first)

  for each query in query order
    func get query tweets (within resonable time)
      get query tweets in best order (doesn't get ones done etc)
      filter out bad tweets

    i = 0

    while there are more tweets to process
      get query tweets in best order (doesn't get ones done etc) (pagination with i)

      if there are no tweets
        end while

      filter out bad tweets

      if there is a tweet
        retweet
        exit and move on to next account

      i++


*/
