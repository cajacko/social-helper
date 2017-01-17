import React from 'react'
import TextInput from '~/components/TextInput/TextInput'

const Query = React.createClass({
  onChange: function() {

  },
  
  render: function() {
    return (
      <li>
        <TextInput
          placeholder=""
          onChange={this.onChange}
          value="#iot"
          password={false}
        />

        <button>Update</button>
        <button>Remove Query</button>
      </li>
    )
  }
})

export default Query
