import React from 'react'
import {connect} from 'react-redux'
import App from '~/components/App/App'

const AppContainer = React.createClass({
  render: function() {
    return (
      <App>
        {this.props.children}
      </App>
    )
  }
})

export default AppContainer
