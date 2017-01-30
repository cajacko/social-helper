import React from 'react'
import Heading from '~/components/Heading/Heading'
import {style} from '~/components/App/App.style'

const App = React.createClass({
  render: function() {
    return (
      <div style={style.container}>
        <Heading style={style.title} text="Social Helper" level={1} />
        {this.props.children}
      </div>
    )
  }
})

export default App
