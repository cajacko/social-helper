import React from 'react'
import {connect} from 'react-redux'
import Cron from '~/components/Cron/Cron'
import {updateCron} from '~/actions/cron'

const CronContainer = React.createClass({
  submit: function(cron) {
    this.props.dispatch(updateCron(cron))
  },

  render: function() {
    return (
      <Cron
        cron={this.props.cron}
        submit={this.submit}
      />
    )
  }
})

function mapStateToProps(state) {
  return {
    cron: state.cron
  }
}

export default connect(mapStateToProps)(CronContainer)
