import React from 'react'
import {connect} from 'react-redux'
import Account from '~/components/Account/Account'
import * as propTypes from '~/constants/propTypes'
import {updateQuery, deleteQuery, createQuery} from '~/actions/query'
import {deleteAccount, updateCron} from '~/actions/account'

const AccountContainer = React.createClass({
  propTypes: {
    queries: propTypes.QUERIES,
    username: propTypes.USERNAME,
    id: propTypes.ACCOUNT_ID,
    cron: propTypes.CRON
  },

  getInitialState: function() {
    let queries = Object.assign([], this.props.queries)

    if (!queries.length) {
      queries.push({
        query: '',
        id: false
      })
    }

    return {
      queries: queries
    }
  },

  componentWillReceiveProps: function(nextProps) {
    if (this.props.queries !== nextProps.queries) {
      this.setState({
        queries: nextProps.queries
      })
    }
  },

  deleteQuery: function(id) {
    this.props.dispatch(deleteQuery(id, this.props.id))
  },

  createQuery: function(query) {
    this.props.dispatch(createQuery(query, this.props.id))
  },

  addQuery: function() {
    let queries = Object.assign([], this.state.queries)
    queries.push({
      query: '',
      id: false
    })

    this.setState({
      queries: queries
    })
  },

  delete: function() {
    this.props.dispatch(deleteAccount(this.props.id))
  },

  cronSubmit: function(cron) {
    this.props.dispatch(updateCron(this.props.id, cron))
  },

  render: function() {
    let showAddButton = true

    this.state.queries.forEach(function(query) {
      if (!query.id) {
        showAddButton = false
      }
    })

    return (
      <Account
        queries={this.state.queries}
        username={this.props.username}
        deleteQuery={this.deleteQuery}
        createQuery={this.createQuery}
        addQuery={this.addQuery}
        delete={this.delete}
        showAddButton={showAddButton}
        cron={this.props.cron}
        cronSubmit={this.cronSubmit}
      />
    )
  }
})

export default connect()(AccountContainer)
