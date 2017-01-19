import {twitter} from './twitter'
import errorResponse from './errorResponse'

export default function(req, res) {
  const sess = req.session

  twitter.getRequestToken(function(error, requestToken, requestTokenSecret, results){
    if (error) {
      res.json(errorResponse(2, 'Error getting Twitter request token', error))
    } else {
      sess.requestToken = requestToken
      sess.requestTokenSecret = requestTokenSecret

      let url = 'https://twitter.com/oauth/authorize?oauth_token=' + requestToken

      res.redirect(url)
    }
  })
}
