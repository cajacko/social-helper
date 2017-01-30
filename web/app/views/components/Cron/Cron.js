import React from 'react'
import TextInput from '~/components/TextInput/TextInput'
import * as propTypes from '~/constants/propTypes'
import {style} from '~/components/Cron/Cron.style'
import Heading from '~/components/Heading/Heading'
import Button from '~/components/Button/Button'

const Cron = React.createClass({
  propTypes: {
    cron: propTypes.CRON,
    submit: propTypes.CRON_UPDATE
  },

  getInitialState: function() {
    return {
      cron: this.props.cron
    }
  },

  componentWillReceiveProps(nextProps) {
    if (this.props.cron == nextProps.cron) {
      return false
    }

    this.setState({
      cron: nextProps.cron
    })
  },

  onChange: function(event) {
    this.setState({
      cron: event.target.value
    })
  },

  submit: function() {
    this.props.submit(this.state.cron)
  },

  render: function() {
    return (
      <div>
        <Heading text="Cron" level={5} />

        <TextInput
          placeholder="Cron"
          onChange={this.onChange}
          value={this.state.cron}
          password={false}
        />

        <Button onClick={this.submit} text="Submit" />
      </div>
    )
  }
})

export default Cron
