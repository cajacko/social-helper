import React from 'react'
import {style} from '~/components/TextInput/TextInput.style'
import * as propTypes from '~/constants/propTypes'

const TextInput = React.createClass({
  propTypes: {
    password: propTypes.INPUT_HAS_PASSWORD,
    placeholder: propTypes.INPUT_PLACEHOLDER,
    onChange: propTypes.INPUT_ON_CHANGE,
    value: propTypes.INPUT_VALUE
  },

  render: function() {
    var type = 'text'

    if (this.props.password) {
      type = 'password'
    }

    return (
      <div style={style.container}>
        <input
          style={style.input}
          type={type}
          placeholder={this.props.placeholder}
          onChange={this.props.onChange}
          value={this.props.value}
        />
      </div>
    )
  }
})

export default TextInput
