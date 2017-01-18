import React from 'react'
import TextInput from '~/components/TextInput/TextInput'
import * as propTypes from '~/constants/propTypes'

const Query = React.createClass({
  propTypes: {
    query: propTypes.QUERY,
    id: propTypes.QUERY_ID,
    update: propTypes.QUERY_UPDATE,
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

  onChange: function(event) {
    this.setState({
      query: event.target.value
    })
  },

  submit: function() {
    if (this.props.id) {
      this.props.update(this.props.id, this.state.query)
    } else {
      this.props.create(this.state.query)
    }
  },

  delete: function() {
    this.props.delete(this.props.id)
  },

  render: function() {
    let deleteQuery = false

    if (this.props.id) {
      deleteQuery = <button onClick={this.delete}>Delete Query</button>
    }

    return (
      <li>
        <TextInput
          placeholder="Query"
          onChange={this.onChange}
          value={this.state.query}
          password={false}
        />

        <button onClick={this.submit}>{this.state.updateText}</button>
        {deleteQuery}
      </li>
    )
  }
})

export default Query
