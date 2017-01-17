import * as actionTypes from '~/constants/actions'
import getFetcherAction from '~/helpers/getFetcherAction'
import {SUCCESS} from '~/constants/fetcher'

export default function(state = false, action) {
  switch(action.type) {
    case getFetcherAction(actionTypes.LOGIN, SUCCESS):
      return action.payload.data.loggedIn
    default:
      return state
  }
}
