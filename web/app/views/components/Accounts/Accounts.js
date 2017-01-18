import React from 'react'
import Account from '~/containers/Account/Account'
import * as propTypes from '~/constants/propTypes'

const Accounts = React.createClass({
  propTypes: {
    accounts: propTypes.ACCOUNTS,
    add: propTypes.ACCOUNT_ADD
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

        <button onClick={this.props.add}>Add Account</button>
      </div>
    )
  }
})

export default Accounts
