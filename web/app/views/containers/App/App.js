import React from 'react'
import {connect} from 'react-redux'
import App from '~/components/App/App'
import {userRead} from '~/actions/user'

const AppContainer = React.createClass({
  componentDidMount: function() {
    this.props.dispatch(userRead())
  },

  render: function() {
    return (
      <App>
        {this.props.children}
      </App>
    )
  }
})

export default connect()(AppContainer)
