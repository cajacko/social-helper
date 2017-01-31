import React from 'react'
import Account from '~/containers/Account/Account'
import * as propTypes from '~/constants/propTypes'
import Heading from '~/components/Heading/Heading'
import {style} from '~/components/Accounts/Accounts.style'
import Button from '~/components/Button/Button'

const Accounts = React.createClass({
  propTypes: {
    accounts: propTypes.ACCOUNTS,
  },

  addAccount: function () {
    window.location.href = '/auth/twitter/login'
  },

  render: function() {
    return (
      <div style={style.container}>
        <Heading level={3} text="Accounts" />

        <div>
          {
            this.props.accounts.map(function(account) {
              return (
                <Account
                  key={account.username}
                  queries={account.queries}
                  username={account.username}
                  id={account.id}
                  cron={account.cron}
                  blacklist={account.blacklist}
                />
              )
            })
          }
        </div>

        <Button onClick={this.addAccount} text="Add Account"/>
      </div>
    )
  }
})

export default Accounts
