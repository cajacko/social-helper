import React from 'react'
import Account from '~/components/Account/Account'

const Accounts = React.createClass({
  render: function() {
    return (
      <div>
        <h2>Accounts</h2>

        <div>
          <Account />
          <Account />
          <Account />
          <Account />
        </div>

        <button>Add Account</button>
      </div>
    )
  }
})

export default Accounts
