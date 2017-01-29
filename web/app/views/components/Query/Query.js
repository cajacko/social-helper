import React from 'react'
import TextInput from '~/components/TextInput/TextInput'
import * as propTypes from '~/constants/propTypes'

const Query = React.createClass({
  propTypes: {
    query: propTypes.QUERY,
    id: propTypes.QUERY_ID,
    delete: propTypes.QUERY_DELETE,
    create: propTypes.QUERY_CREATE
  },

  getInitialState: function() {
    let query = ''
    let updateText = 'Create'

    if (this.props.id) {
      query = this.props.query
      updateText = 'Update'
    }

    return {
      query: query,
      updateText: updateText
    }
  },

  componentWillReceiveProps(nextProps) {
    if (this.props.query == nextProps.query && this.props.id == nextProps.id) {
      return false
    }

    this.setState({
      query: nextProps.query,
      id: nextProps.id
    })
  },

  onChange: function(event) {
    this.setState({
      query: event.target.value
    })
  },

  submit: function() {
    this.props.create(this.state.query)
  },

  delete: function() {
    this.props.delete(this.props.id)
  },

  render: function() {
    let deleteQuery = false
    let createQuery = false

    if (this.props.id) {
      deleteQuery = <button onClick={this.delete}>Delete Query</button>
    } else {
      createQuery = <button onClick={this.submit}>Create</button>
    }

    return (
      <li>
        <TextInput
          placeholder="Query"
          onChange={this.onChange}
          value={this.state.query}
          password={false}
        />

        {createQuery}
        {deleteQuery}
      </li>
    )
  }
})

export default Query
