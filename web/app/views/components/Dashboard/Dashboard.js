import React from 'react'
import Cron from '~/containers/Cron/Cron'
import Accounts from '~/containers/Accounts/Accounts'

const Dashboard = React.createClass({
  render: function() {
    return (
      <div>
        <h1>Dashboard</h1>
        <button>Log Out</button>

        <Accounts />
        <Cron />
      </div>
    )
  }
})

export default Dashboard
