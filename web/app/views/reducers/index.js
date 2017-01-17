import {combineReducers} from 'redux'
import {routerReducer} from 'react-router-redux'
// import status from '~/reducers/status'
// import gameState from '~/reducers/gameState'
// import id from '~/reducers/id'

const app = combineReducers({
  // id,
  // gameState,
  // status,
  routing: routerReducer
})

export default app
