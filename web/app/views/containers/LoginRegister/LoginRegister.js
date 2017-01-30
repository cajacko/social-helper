import React from 'react'
import LoginRegister from '~/components/LoginRegister/LoginRegister'
import {login, create} from '~/actions/user'
import {connect} from 'react-redux'
import * as propTypes from '~/constants/propTypes'

const LoginRegisterContainer = React.createClass({
  propTypes: {
    login: propTypes.LOGIN
  },

  onSubmit: function(isLogin, email, password, passwordConfirm) {
    if (isLogin) {
      this.props.dispatch(login(email, password))
    } else {
      this.props.dispatch(create(email, password, passwordConfirm))
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
