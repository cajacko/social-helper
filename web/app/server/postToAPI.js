import request from 'request'
import errorResponse from './errorResponse'

export function postFromFrontEnd(req, res) {
  const endpoint = req.params.controller + '/' + req.params.endpoint

  postToAPI(endpoint, req.body, function(response) {
    res.json(response)
  }, function(body) {
    res.json(body)
  })
}

export function postToAPI(endpoint, data, error, success) {
  const options = {
    url: process.env.API_DOMAIN + endpoint,
    headers: {

    },
    json: data
  }

  request.post(
    options,
    function (error, response, body) {
      if (error) {
        return error(errorResponse(6, 'API returned an error', error))
      }

      if (response.statusCode != 200) {
        return error(errorResponse(7, 'API did not return 200 status code', response))
      }

      success(body)
    }
  )
}
