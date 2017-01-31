import React from 'react'
import Query from '~/components/Query/Query'
import * as propTypes from '~/constants/propTypes'
import Button from '~/components/Button/Button'
import Heading from '~/components/Heading/Heading'
import {style} from '~/components/Queries/Queries.style'

const Queries = React.createClass({
  propTypes: {
    queries: propTypes.QUERIES,
    delete: propTypes.QUERY_DELETE,
    create: propTypes.QUERY_CREATE,
    add: propTypes.QUERY_ADD,
    showAddButton: propTypes.QUERY_SHOW_ADD_BUTTON,
    title: propTypes.QUERIES_TITLE,
    addText: propTypes.QUERY_ADD_TEXT,
    removeText: propTypes.QUERY_REMOVE_TEXT
  },

  render: function() {
    const deleteQuery = this.props.delete
    const createQuery = this.props.create
    const removeText = this.props.removeText

    let addButton = false

    if (this.props.showAddButton) {
      addButton = <Button onClick={this.props.add} text={this.props.addText} />
    }

    return (
      <div style={style.container}>
        <Heading text={this.props.title} level={5} />

        <ul style={style.list}>
          {
            this.props.queries.map(function(query) {
              return (
                <Query
                  key={query.id}
                  id={query.id}
                  query={query.query}
                  delete={deleteQuery}
                  create={createQuery}
                  removeText={removeText}
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
