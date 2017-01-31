import * as actionTypes from '~/constants/actions'
import getFetcherAction from '~/helpers/getFetcherAction'
import {SUCCESS} from '~/constants/fetcher'

const defaultState = false

export default function(state = defaultState, action) {
  switch(action.type) {
    case getFetcherAction(actionTypes.USER_LOGIN, SUCCESS):
    case getFetcherAction(actionTypes.USER_READ, SUCCESS):
    case getFetcherAction(actionTypes.USER_CREATE, SUCCESS):
    case getFetcherAction(actionTypes.CRON_UPDATE, SUCCESS):
    case getFetcherAction(actionTypes.QUERY_UPDATE, SUCCESS):
    case getFetcherAction(actionTypes.QUERY_CREATE, SUCCESS):
    case getFetcherAction(actionTypes.QUERY_DELETE, SUCCESS):
    case getFetcherAction(actionTypes.BLACKLIST_ITEM_DELETE, SUCCESS):
    case getFetcherAction(actionTypes.BLACKLIST_ITEM_CREATE, SUCCESS):
    case getFetcherAction(actionTypes.ACCOUNT_DELETE, SUCCESS):
      if (action.payload.data.accounts) {
        return action.payload.data.accounts
      }

      return state

    case getFetcherAction(actionTypes.USER_LOGOUT, SUCCESS):
      if (!action.payload.data.loggedIn) {
        return defaultState
      }

      return state

    default:
      return state
  }
}
