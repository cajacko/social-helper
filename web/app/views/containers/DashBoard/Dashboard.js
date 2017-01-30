import React from 'react'
import {connect} from 'react-redux'
import Dashboard from '~/components/Dashboard/Dashboard'
import {logout} from '~/actions/user'

const DashboardContainer = React.createClass({
  logout: function() {
    this.props.dispatch(logout())
  },

  render: function() {
    return (
      <Dashboard
        logout={this.logout}
      />
    )
  }
})

export default connect()(DashboardContainer)
