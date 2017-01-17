import React from 'react'
import Queries from '~/components/Queries/Queries'

const Account = React.createClass({
  render: function() {
    return (
      <div>
        <h3>@charliejackson</h3>
        <button>Remove Account</button>

        <Queries />
      </div>
    )
  }
})

export default Account
