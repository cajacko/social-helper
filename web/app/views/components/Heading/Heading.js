import React from 'react'
import * as propTypes from '~/constants/propTypes'
import {style} from '~/components/Heading/Heading.style'

const Heading = React.createClass({
  propTypes: {
    text: propTypes.HEADING_TEXT,
    level: propTypes.HEADING_LEVEL
  },

  render: function() {
    let styles

    switch (this.props.level) {
      case 1:
        styles = Object.assign({}, style.base, style.h1)
        return <h1 style={styles} >{this.props.text}</h1>
      case 2:
        styles = Object.assign({}, style.base, style.h2)
        return <h2 style={styles} >{this.props.text}</h2>
      case 3:
        styles = Object.assign({}, style.base, style.h3)
        return <h3 style={styles} >{this.props.text}</h3>
      case 4:
        styles = Object.assign({}, style.base, style.h4)
        return <h4 style={styles} >{this.props.text}</h4>
      case 5:
        styles = Object.assign({}, style.base, style.h5)
        return <h5 style={styles} >{this.props.text}</h5>
      default:
        styles = Object.assign({}, style.base, style.h6)
        return <h6 style={styles} >{this.props.text}</h6>
    }
  }
})

export default Heading
