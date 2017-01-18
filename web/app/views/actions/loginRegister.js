import fetcher from '~/helpers/fetcher'
import * as actionTypes from '~/constants/actions'

export function login(email, password) {
  const data = {
    email: email,
    password: password
  }

  return fetcher('user/login', data, actionTypes.LOGIN)
}

export function register(email, password, passwordConfirm) {
  const data = {
    email: email,
    password: password,
    passwordConfirm: passwordConfirm
  }

  return fetcher('user/create', data, actionTypes.REGISTER)
}
