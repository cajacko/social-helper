import React from 'react'
import TextInput from '~/components/TextInput/TextInput'
import * as propTypes from '~/constants/propTypes'

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
        <h2>Cron</h2>

        <TextInput
          placeholder="Cron"
          onChange={this.onChange}
          value={this.state.cron}
          password={false}
        />

        <button onClick={this.submit}>Submit</button>
      </div>
    )
  }
})

export default Cron
