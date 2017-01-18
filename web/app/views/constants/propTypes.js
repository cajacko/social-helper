import React from 'react'

export const USERNAME = React.PropTypes.string.isRequired

export const ACCOUNTS = React.PropTypes.array.isRequired
export const ACCOUNT_DELETE = React.PropTypes.func.isRequired
export const ACCOUNT_ADD = React.PropTypes.func.isRequired
export const ACCOUNT_ID = React.PropTypes.string.isRequired

export const QUERIES = React.PropTypes.array.isRequired
export const QUERY = React.PropTypes.string.isRequired
export const QUERY_ID = React.PropTypes.oneOfType([
  React.PropTypes.string,
  React.PropTypes.bool
]).isRequired
export const QUERY_UPDATE = React.PropTypes.func.isRequired
export const QUERY_DELETE = React.PropTypes.func.isRequired
export const QUERY_CREATE = React.PropTypes.func.isRequired
export const QUERY_ADD = React.PropTypes.func.isRequired
export const QUERY_SHOW_ADD_BUTTON = React.PropTypes.bool.isRequired

export const LOGOUT = React.PropTypes.func.isRequired
export const USER_CREATE = React.PropTypes.func.isRequired
export const LOGIN = React.PropTypes.bool.isRequired

export const CRON = React.PropTypes.string.isRequired
export const CRON_UPDATE = React.PropTypes.func.isRequired

export const INPUT_HAS_PASSWORD = React.PropTypes.bool.isRequired
export const INPUT_PLACEHOLDER = React.PropTypes.string.isRequired
export const INPUT_ON_CHANGE = React.PropTypes.func.isRequired
export const INPUT_VALUE = React.PropTypes.string.isRequired
