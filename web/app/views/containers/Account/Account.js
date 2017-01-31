import React from 'react'
import {connect} from 'react-redux'
import Account from '~/components/Account/Account'
import * as propTypes from '~/constants/propTypes'
import {updateQuery, deleteQuery, createQuery} from '~/actions/query'
import {deleteAccount, updateCron} from '~/actions/account'
import {createBlacklistItem, deleteBlacklistItem} from '~/actions/blacklist'

const AccountContainer = React.createClass({
  propTypes: {
    queries: propTypes.QUERIES,
    username: propTypes.USERNAME,
    id: propTypes.ACCOUNT_ID,
    cron: propTypes.CRON,
    blacklist: propTypes.QUERIES
  },

  getInitialState: function() {
    let queries = Object.assign([], this.props.queries)

    if (!queries.length) {
      queries.push({
        query: '',
        id: false
      })
    }

    let blacklist = Object.assign([], this.props.blacklist)

    if (!blacklist.length) {
      blacklist.push({
        query: '',
        id: false
      })
    }

    return {
      queries: queries,
      blacklist: blacklist
    }
  },

  componentWillReceiveProps: function(nextProps) {
    let changeState = false
    let state = {}

    if (this.props.queries !== nextProps.queries) {
      state.queries = nextProps.queries
      changeState = true
    }

    if (this.props.blacklist !== nextProps.blacklist) {
      state.blacklist = nextProps.blacklist
      changeState = true
    }

    if (changeState) {
      this.setState(state)
    }
  },

  deleteQuery: function(id) {
    this.props.dispatch(deleteQuery(id, this.props.id))
  },

  createQuery: function(query) {
    this.props.dispatch(createQuery(query, this.props.id))
  },

  createBlacklistItem: function(query) {
    this.props.dispatch(createBlacklistItem(query, this.props.id))
  },

  deleteBlacklistItem: function(id) {
    this.props.dispatch(deleteBlacklistItem(id, this.props.id))
  },

  addBlacklist: function() {
    let blacklist = Object.assign([], this.state.blacklist)

    blacklist.push({
      query: '',
      id: false
    })

    this.setState({
      blacklist: blacklist
    })
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
        blacklist={this.state.blacklist}
        deleteBlacklistItem={this.deleteBlacklistItem}
        createBlacklistItem={this.createBlacklistItem}
        addBlacklist={this.addBlacklist}
      />
    )
  }
})

export default connect()(AccountContainer)
