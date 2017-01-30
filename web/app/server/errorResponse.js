import errors from './errors'

export default function (code, data = false) {
  var error

  if (!errors) {
    error = {
      status: 200,
      code: 0,
      message: 'Could not load errors',
      data: {
        code: code,
        data: data
      }
    }
  } else if (!code) {
    error = {
      code: 0,
      status: 200,
      message: 'No error code given',
      data: data
    }
  } else if (!errors[code]) {
    error = {
      code: 0,
      status: 200,
      message: 'Error code does not exist',
      data: {
        code: code,
        data: data
      }
    }
  } else {
    error = errors[code]
    error.data = data
  }

  error.error = true

  return error
}
