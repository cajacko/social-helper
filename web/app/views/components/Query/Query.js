import React from 'react'
import TextInput from '~/components/TextInput/TextInput'
import * as propTypes from '~/constants/propTypes'
import Button from '~/components/Button/Button'
import {style} from '~/components/Query/Query.style'

const Query = React.createClass({
  propTypes: {
    query: propTypes.QUERY,
    id: propTypes.QUERY_ID,
    delete: propTypes.QUERY_DELETE,
    create: propTypes.QUERY_CREATE,
    removeText: propTypes.QUERY_REMOVE_TEXT
  },

  getInitialState: function() {
    let query = ''

    if (this.props.id) {
      query = this.props.query
    }

    return {
      query: query
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
      deleteQuery = <Button onClick={this.delete} text={this.props.removeText} />
    } else {
      createQuery = <Button onClick={this.submit} text="Create" />
    }

    return (
      <li style={style.container}>
        <TextInput
          placeholder="Text"
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
