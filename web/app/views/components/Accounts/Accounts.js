import React from 'react'
import Account from '~/containers/Account/Account'
import * as propTypes from '~/constants/propTypes'

const Accounts = React.createClass({
  propTypes: {
    accounts: propTypes.ACCOUNTS
  },

  render: function() {
    return (
      <div>
        <h2>Accounts</h2>

        <div>
          {
            this.props.accounts.map(function(account) {
              return (
                <Account
                  key={account.username}
                  queries={account.queries}
                  username={account.username}
                  id={account.id}
                />
              )
            })
          }
        </div>

        <a href="/auth/twitter/login">Add Account</a>
      </div>
    )
  }
})

export default Accounts
