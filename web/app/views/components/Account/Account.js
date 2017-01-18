import React from 'react'
import Queries from '~/components/Queries/Queries'
import * as propTypes from '~/constants/propTypes'

const Account = React.createClass({
  propTypes: {
    queries: propTypes.QUERIES,
    username: propTypes.USERNAME,
    updateQuery: propTypes.QUERY_UPDATE,
    deleteQuery: propTypes.QUERY_DELETE,
    createQuery: propTypes.QUERY_CREATE,
    addQuery: propTypes.QUERY_ADD,
    delete: propTypes.ACCOUNT_DELETE,
    showAddButton: propTypes.QUERY_SHOW_ADD_BUTTON
  },

  render: function() {
    return (
      <div>
        <h3>@{this.props.username}</h3>
        <button onClick={this.props.delete}>Remove Account</button>

        <Queries
          queries={this.props.queries}
          update={this.props.updateQuery}
          create={this.props.createQuery}
          delete={this.props.deleteQuery}
          add={this.props.addQuery}
          showAddButton={this.props.showAddButton}
        />
      </div>
    )
  }
})

export default Account
