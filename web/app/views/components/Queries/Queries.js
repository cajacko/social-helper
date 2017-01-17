import React from 'react'
import Query from '~/components/Query/Query'

const Queries = React.createClass({
  render: function() {
    return (
      <div>
        <h4>Queries</h4>

        <ul>
          <Query />
          <Query />
          <Query />
          <Query />
        </ul>

        <button>Add query</button>
      </div>
    )
  }
})

export default Queries
