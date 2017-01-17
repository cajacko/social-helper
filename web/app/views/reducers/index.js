import {combineReducers} from 'redux'
import {routerReducer} from 'react-router-redux'
import loggedIn from '~/reducers/loggedIn'
import accounts from '~/reducers/accounts'
import cron from '~/reducers/cron'

const app = combineReducers({
  loggedIn,
  accounts,
  cron,
  routing: routerReducer
})

export default app
