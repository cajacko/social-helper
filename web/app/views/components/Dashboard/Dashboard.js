import React from 'react'
import Accounts from '~/containers/Accounts/Accounts'
import * as propTypes from '~/constants/propTypes'
import Heading from '~/components/Heading/Heading'
import Button from '~/components/Button/Button'
import {style} from '~/components/Dashboard/Dashboard.style'

const Dashboard = React.createClass({
  propTypes: {
    logout: propTypes.LOGOUT
  },

  render: function() {
    return (
      <div>
        <div style={style.heading}>
          <Heading level={2} text="Dashboard" />
          <Button onClick={this.props.logout} text="Log Out" />
        </div>

        <Accounts />
      </div>
    )
  }
})

export default Dashboard
