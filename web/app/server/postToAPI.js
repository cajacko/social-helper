import request from 'request'
import errorResponse from './errorResponse'
import filterLoginResponse from './filterLoginResponse'

export function postFromFrontEnd(req, res) {
  const endpoint = req.params.controller + '/' + req.params.endpoint

  postToAPI(endpoint, req.body, req, function(response) {
    res.json(response)
    res.end()
  }, function(body) {
    let data = body

    switch(endpoint) {
      case 'user/login':
      case 'user/create':
        data = filterLoginResponse(body, req)
        break;

      case 'user/logout':
        req.session.destroy()
    }

    res.json(data)
  })
}

export function postToAPI(endpoint, data, req, errorCallback, successCallback) {
  if (req.session.auth) {
    data.auth = req.session.auth
  }

  if (process.env.APP_AUTH) {
    data.appAuth = process.env.APP_AUTH
  }

  const options = {
    url: process.env.API_DOMAIN + endpoint,
    body: data,
    method: 'post',
    json: true
  }

  console.log("\n")
  console.log('POST')
  console.log(options)
  console.log(data)
  console.log("\n")

  request.post(
    options,
    function (error, response, body) {
      console.log("\n")
      console.log('POST RECIEVE')
      console.log(body)
      console.log("\n")

      if (error) {
        return errorCallback(errorResponse(6, error))
      }

      if (response.statusCode != 200) {
        return errorCallback(errorResponse(7, response))
      }

      if (typeof body !== 'object') {
        return errorCallback(errorResponse(20, response))
      }

      successCallback(body)
    }
  )
}
