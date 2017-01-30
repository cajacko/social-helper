import fetcher from '~/helpers/fetcher'
import * as actionTypes from '~/constants/actions'

export function login(email, password) {
  const data = {
    email: email,
    password: password
  }

  return fetcher('user/login', data, actionTypes.USER_LOGIN)
}

export function create(email, password, passwordConfirm) {
  const data = {
    email: email,
    password: password,
    passwordConfirm: passwordConfirm
  }

  return fetcher('user/create', data, actionTypes.USER_CREATE)
}

export function logout() {
  return fetcher('user/logout', false, actionTypes.USER_LOGOUT)
}

export function userRead() {
  return fetcher('user/read', false, actionTypes.USER_READ)
}
