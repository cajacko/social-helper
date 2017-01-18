import React from 'react'
import Query from '~/components/Query/Query'
import * as propTypes from '~/constants/propTypes'

const Queries = React.createClass({
  propTypes: {
    queries: propTypes.QUERIES,
    update: propTypes.QUERY_UPDATE,
    delete: propTypes.QUERY_DELETE,
    create: propTypes.QUERY_CREATE,
    add: propTypes.QUERY_ADD,
    showAddButton: propTypes.QUERY_SHOW_ADD_BUTTON
  },

  render: function() {
    const updateQuery = this.props.update
    const deleteQuery = this.props.delete
    const createQuery = this.props.create

    let addButton = false

    if (this.props.showAddButton) {
      addButton = <button onClick={this.props.add}>Add query</button>
    }

    return (
      <div>
        <h4>Queries</h4>

        <ul>
          {
            this.props.queries.map(function(query) {
              return (
                <Query
                  key={query}
                  query={query}
                  update={updateQuery}
                  delete={deleteQuery}
                  create={createQuery}
                />
              )
            })
          }
        </ul>

        {addButton}
      </div>
    )
  }
})

export default Queries
