import React from 'react'
import {connect} from 'react-redux'
import Home from '~/components/Home/Home'
import Dashboard from '~/containers/Dashboard/Dashboard'

const HomeContainer = React.createClass({
  render: function() {
    if (this.props.loggedIn) {
      return <Dashboard />
    } else {
      return <Home />
    }
  }
})

function mapStateToProps(state) {
  return {
    loggedIn: state.loggedIn
  }
}

export default connect(mapStateToProps)(HomeContainer)
