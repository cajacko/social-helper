import React from 'react'
import Queries from '~/components/Queries/Queries'
import * as propTypes from '~/constants/propTypes'
import Cron from '~/components/Cron/Cron'

const Account = React.createClass({
  propTypes: {
    queries: propTypes.QUERIES,
    username: propTypes.USERNAME,
    deleteQuery: propTypes.QUERY_DELETE,
    createQuery: propTypes.QUERY_CREATE,
    addQuery: propTypes.QUERY_ADD,
    delete: propTypes.ACCOUNT_DELETE,
    showAddButton: propTypes.QUERY_SHOW_ADD_BUTTON,
    cron: propTypes.CRON,
    cronSubmit: propTypes.CRON_UPDATE
  },

  render: function() {
    return (
      <div>
        <h3>@{this.props.username}</h3>
        <button onClick={this.props.delete}>Remove Account</button>

        <Queries
          queries={this.props.queries}
          create={this.props.createQuery}
          delete={this.props.deleteQuery}
          add={this.props.addQuery}
          showAddButton={this.props.showAddButton}
        />

        <Cron
          cron={this.props.cron}
          submit={this.props.cronSubmit}
        />
      </div>
    )
  }
})

export default Account
