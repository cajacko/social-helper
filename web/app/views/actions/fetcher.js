import getFetcherAction from '~/helpers/getFetcherAction'
import {INIT, ERROR, SUCCESS} from '~/constants/fetcher'

var callStatus = {}

export function  init(url, postData, action, id) {
  callStatus[id] = new Date()

  return {
    type: getFetcherAction(action, INIT),
    payload: {
      url: url,
      postData: postData,
      fetcher: {
        action: action,
        id: id,
      }
    }
  }
}

export function  success(data, url, postData, action, id) {
  return dispatch => {
    if (!callStatus[id]) {
      return false
    }

    delete callStatus[id]

    dispatch({
      type: getFetcherAction(action, SUCCESS),
      payload: {
        url: url,
        postData: postData,
        data: data,
        fetcher: {
          action: action,
          id: id
        }
      }
    })
  }
}

export function  failure(error, url, postData, action, id) {
  return dispatch => {
    if (!callStatus[id]) {
      return false
    }

    delete callStatus[id]

    dispatch({
      type: getFetcherAction(action, ERROR),
      payload: {
        error: error,
        url: url,
        postData: postData,
        fetcher: {
          action: action,
          id: id
        }
      }
    })
  }
}
