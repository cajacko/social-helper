import React from 'react'
import Cron from '~/components/Cron/Cron'
import Accounts from '~/components/Accounts/Accounts'

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
