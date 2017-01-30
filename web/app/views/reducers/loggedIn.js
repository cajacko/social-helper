import * as actionTypes from '~/constants/actions'
import getFetcherAction from '~/helpers/getFetcherAction'
import {SUCCESS} from '~/constants/fetcher'

export default function(state = false, action) {
  switch(action.type) {
    case getFetcherAction(actionTypes.USER_LOGIN, SUCCESS):
    case getFetcherAction(actionTypes.USER_LOGOUT, SUCCESS):
    case getFetcherAction(actionTypes.USER_READ, SUCCESS):
    case getFetcherAction(actionTypes.USER_CREATE, SUCCESS):
    case getFetcherAction(actionTypes.CRON_UPDATE, SUCCESS):
    case getFetcherAction(actionTypes.QUERY_UPDATE, SUCCESS):
    case getFetcherAction(actionTypes.QUERY_CREATE, SUCCESS):
    case getFetcherAction(actionTypes.QUERY_DELETE, SUCCESS):
    case getFetcherAction(actionTypes.ACCOUNT_DELETE, SUCCESS):
      return action.payload.data.loggedIn

    default:
      return state
  }
}
