import React from 'react'
import TextInput from '~/components/TextInput/TextInput'

const Cron = React.createClass({
  onChange: function() {

  },

  render: function() {
    return (
      <div>
        <h2>Cron</h2>

        <TextInput
          placeholder=""
          onChange={this.onChange}
          value="soihf joifj dpj "
          password={false}
        />

        <button>Submit</button>
      </div>
    )
  }
})

export default Cron
