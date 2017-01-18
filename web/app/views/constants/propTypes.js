import React from 'react'

export const USERNAME = React.PropTypes.string.isRequired

export const ACCOUNTS = React.PropTypes.array.isRequired
export const ACCOUNT_DELETE = React.PropTypes.func.isRequired
export const ACCOUNT_ADD = React.PropTypes.func.isRequired

export const QUERIES = React.PropTypes.array.isRequired
export const QUERY = React.PropTypes.oneOfType([
  React.PropTypes.string,
  React.PropTypes.bool
]).isRequired
export const QUERY_UPDATE = React.PropTypes.func.isRequired
export const QUERY_DELETE = React.PropTypes.func.isRequired
export const QUERY_CREATE = React.PropTypes.func.isRequired
export const QUERY_ADD = React.PropTypes.func.isRequired
export const QUERY_SHOW_ADD_BUTTON = React.PropTypes.bool.isRequired
