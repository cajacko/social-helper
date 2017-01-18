import React from 'react'
import {connect} from 'react-redux'
import Accounts from '~/components/Accounts/Accounts'

const AccountsContainer = React.createClass({
  render: function() {
    return (
      <Accounts
        accounts={this.props.accounts}
      />
    )
  }
})

function mapStateToProps(state) {
  return {
    accounts: state.accounts
  }
}

export default connect(mapStateToProps)(AccountsContainer)
