import React from 'react'
import LoginRegister from '~/components/LoginRegister/LoginRegister'
import {login, register} from '~/actions/loginRegister'
import {connect} from 'react-redux'

const LoginRegisterContainer = React.createClass({
  propTypes: {
    login: React.PropTypes.bool.isRequired
  },

  onSubmit: function(isLogin, email, password, passwordConfirm) {
    if (isLogin) {
      this.props.dispatch(login(email, password))
    } else {
      this.props.dispatch(register(email, password, passwordConfirm))
    }
  },

  render: function() {
    return (
      <LoginRegister
        login={this.props.login}
        onSubmit={this.onSubmit}
      />
    )
  }
})

export default connect()(LoginRegisterContainer)
