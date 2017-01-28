import React from 'react'
import Accounts from '~/containers/Accounts/Accounts'
import * as propTypes from '~/constants/propTypes'

const Dashboard = React.createClass({
  propTypes: {
    logout: propTypes.LOGOUT
  },

  render: function() {
    return (
      <div>
        <h1>Dashboard</h1>
        <button onClick={this.props.logout}>Log Out</button>

        <Accounts />
      </div>
    )
  }
})

export default Dashboard
