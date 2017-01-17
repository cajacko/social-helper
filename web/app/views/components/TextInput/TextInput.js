import React from 'react'

const TextInput = React.createClass({
  propTypes: {
    password: React.PropTypes.bool.isRequired,
    placeholder: React.PropTypes.string.isRequired,
    onChange: React.PropTypes.func.isRequired,
    value: React.PropTypes.string.isRequired
  },

  render: function() {
    var type = 'text'

    if (this.props.password) {
      type = 'password'
    }

    return (
      <div>
        <input
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
