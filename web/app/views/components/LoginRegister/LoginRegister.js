import React from 'react'
import TextInput from '~/components/TextInput/TextInput'
import validator from 'validator'
import * as propTypes from '~/constants/propTypes'
import Heading from '~/components/Heading/Heading'
import Button from '~/components/Button/Button'
import Text from '~/components/Text/Text'
import {style} from '~/components/LoginRegister/LoginRegister.style'

const INPUT_TYPE = {
  EMAIL: 'EMAIL',
  PASSWORD: 'PASSWORD',
  PASSWORD_CONFIRM: 'PASSWORD_CONFIRM'
}

const LoginRegister = React.createClass({
  propTypes: {
    login: propTypes.LOGIN,
    onSubmit: propTypes.USER_CREATE
  },

  getInitialState: function() {
    return {
      [INPUT_TYPE.EMAIL]: '',
      [INPUT_TYPE.PASSWORD]: '',
      [INPUT_TYPE.PASSWORD_CONFIRM]: '',
      emailError: false
    }
  },

  changeInput: function(e, input) {
    var state = {[INPUT_TYPE[input]]: e.target.value}

    if (input == INPUT_TYPE.EMAIL) {
      if (validator.isEmail(this.state[INPUT_TYPE.EMAIL])) {
        state.emailError = false
      } else {
        state.emailError = true
      }
    }

    this.setState(state)
  },

  onSubmit: function() {
    this.props.onSubmit(
      this.props.login,
      this.state[INPUT_TYPE.EMAIL],
      this.state[INPUT_TYPE.PASSWORD],
      this.state[INPUT_TYPE.PASSWORD_CONFIRM]
    )
  },

  render: function() {
    var title = 'Register'
    var confirm = false
    var emailError = false

    if (this.props.login) {
      title = 'Login'
    } else {
      confirm = (
        <TextInput
          password={true}
          placeholder="Password Confirm"
          value={this.state[INPUT_TYPE.PASSWORD_CONFIRM]}
          onChange={(e) => this.changeInput(e, INPUT_TYPE.PASSWORD_CONFIRM)}
        />
      )
    }

    if (this.state.emailError && this.state[INPUT_TYPE.EMAIL].length > 3) {
      emailError = <Text text="Email error" />
    }

    return (
      <div style={style.container}>
        <Heading text={title} level={2} />

        <TextInput
          password={false}
          placeholder="Email"
          value={this.state[INPUT_TYPE.EMAIL]}
          onChange={(e) => this.changeInput(e, INPUT_TYPE.EMAIL)}
        />

        {emailError}

        <TextInput
          password={true}
          placeholder="Password"
          value={this.state[INPUT_TYPE.PASSWORD]}
          onChange={(e) => this.changeInput(e, INPUT_TYPE.PASSWORD)}
        />

        {confirm}

        <Button text="Submit" onClick={this.onSubmit} />
      </div>
    )
  }
})

export default LoginRegister
