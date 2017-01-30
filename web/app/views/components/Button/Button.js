import React from 'react'
import * as propTypes from '~/constants/propTypes'
import {style} from '~/components/Button/Button.style'

const Button = React.createClass({
  propTypes: {
    text: propTypes.BUTTON_TEXT,
    onClick: propTypes.BUTTON_ACTION
  },

  render: function() {
    const styles = Object.assign({}, style.button)

    return (
      <button
        style={styles}
        onClick={this.props.onClick}
      >
        {this.props.text}
      </button>
    )
  }
})

export default Button
