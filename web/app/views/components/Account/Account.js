import React from 'react'
import Queries from '~/components/Queries/Queries'
import * as propTypes from '~/constants/propTypes'
import Cron from '~/components/Cron/Cron'
import Heading from '~/components/Heading/Heading'
import {style} from '~/components/Account/Account.style'
import Button from '~/components/Button/Button'

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
    const heading = '@' + this.props.username

    return (
      <div style={style.container}>
        <div style={style.header}>
          <Heading text={heading} level={4} />
          <Button onClick={this.props.delete} text="Remove Account" />
        </div>

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
