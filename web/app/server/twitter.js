import twitterAPI from 'node-twitter-api'

export const twitter = new twitterAPI({
  consumerKey: process.env.CONSUMER_KEY,
  consumerSecret: process.env.CONSUMER_SECRET,
  callback: process.env.CALLBACK_DOMAIN + 'auth/twitter/callback'
})
