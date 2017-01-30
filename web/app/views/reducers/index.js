import {combineReducers} from 'redux'
import {routerReducer} from 'react-router-redux'
import loggedIn from '~/reducers/loggedIn'
import accounts from '~/reducers/accounts'

const app = combineReducers({
  loggedIn,
  accounts,
  routing: routerReducer
})

export default app
