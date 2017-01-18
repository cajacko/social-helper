import React from 'react'
import {connect} from 'react-redux'
import Account from '~/components/Account/Account'
import * as propTypes from '~/constants/propTypes'

const AccountContainer = React.createClass({
  propTypes: {
    queries: propTypes.QUERIES,
    username: propTypes.USERNAME,
  },

  getInitialState: function() {
    let queries = Object.assign([], this.props.queries)

    if (!queries.length) {
      queries.push(false)
    }

    return {
      queries: queries
    }
  },

  updateQuery: function(query) {
    console.warn('updateQuery')
  },

  deleteQuery: function(query) {
    console.warn('deleteQuery')
  },

  createQuery: function(query) {
    console.warn('createQuery')
  },

  addQuery: function() {
    let queries = Object.assign([], this.state.queries)
    queries.push(false)

    this.setState({
      queries: queries
    })
  },

  delete: function() {
    console.warn('delete')
  },

  render: function() {
    let showAddButton = true

    if (this.state.queries.includes(false)) {
      showAddButton = false
    }

    return (
      <Account
        queries={this.state.queries}
        username={this.props.username}
        updateQuery={this.updateQuery}
        deleteQuery={this.deleteQuery}
        createQuery={this.createQuery}
        addQuery={this.addQuery}
        delete={this.delete}
        showAddButton={showAddButton}
      />
    )
  }
})

export default connect()(AccountContainer)
