import React from 'react'
import {style} from '~/components/Text/Text.style'
import * as propTypes from '~/constants/propTypes'

const Text = React.createClass({
  propTypes: {
    text: propTypes.TEXT
  },

  render: function() {
    return (
      <span style={style.text}>{this.props.text}</span>
    )
  }
})

export default Text
