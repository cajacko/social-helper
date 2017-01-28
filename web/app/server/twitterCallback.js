import {twitter} from './twitter'
import errorResponse from './errorResponse'
import {postToAPI} from './postToAPI'

export default function(req, res) {
  const sess = req.session

  twitter.getAccessToken(
    sess.requestToken,
    sess.requestTokenSecret,
    req.query.oauth_verifier,
    function(error, accessToken, accessTokenSecret, results) {
      if (error) {
        res.json(errorResponse(3, error))
      } else {
        twitter.verifyCredentials(
          accessToken,
          accessTokenSecret,
          function(error, data, response) {
            if (error) {
              res.json(errorResponse(4, error))
            } else {
              const postData = {
                username: data["screen_name"],
                twitter_id: data["id_str"],
                accessToken: accessToken,
                accessTokenSecret: accessTokenSecret
              }

              console.log(postData)

              postToAPI('account/create', postData, req, function(response) {
                console.log(response)
                res.redirect('/error')
              }, function(body) {
                console.log(body)

                if (body.error) {
                  return res.redirect('/error')
                }

                res.redirect('/')
              })
            }
          }
        )
      }
    }
  )
}
