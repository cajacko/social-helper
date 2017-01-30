import {init, failure, success} from '~/actions/fetcher'

var id = 0

export default function(url, postData, action) {
  return dispatch => {
    id++
    const logId = id

    dispatch(init(url, postData, action, logId))

    setTimeout(function() {
      dispatch(failure('TIMEOUT', url, postData, action, logId))
    }, 10000)

    var config = {
      method: 'post',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      credentials: 'same-origin'
    }

    if (postData) {
      config.body = JSON.stringify(postData)
    }

    var requestUrl = '/data/'

    if (url) {
      requestUrl = requestUrl.concat(url)
    }

    return fetch(requestUrl, config)
      .then(response => {
        if (response.status >= 400) {
          dispatch(failure(response, url, postData, action, logId))
        }

        return response.json().then(data => {
          if (data && data.error) {
            return dispatch(failure(data, url, postData, action, logId))
          }

          dispatch(success(data, url, postData, action, logId))
        }).catch(function(e) {
          dispatch(failure(e, url, postData, action, logId))
        })
      }).catch(function(e) {
        dispatch(failure(e, url, postData, action, logId))
      })
  }
}
