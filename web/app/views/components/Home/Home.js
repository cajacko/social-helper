import React from 'react'
import LoginRegister from '~/containers/LoginRegister/LoginRegister'

const Home = React.createClass({
  render: function() {
    return (
      <div>
        <LoginRegister login={true} />
        <LoginRegister login={false} />
      </div>
    )
  }
})

export default Home
