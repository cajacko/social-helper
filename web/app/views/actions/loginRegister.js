import fetcher from '~/helpers/fetcher'
import {LOGIN, REGISTER} from '~/constants/actions'

export function login(email, password) {
  const data = {
    email: email,
    password: password
  }

  return fetcher('login', data, LOGIN)
}

export function register(email, password, passwordConfirm) {
  const data = {
    email: email,
    password: password,
    passwordConfirm: passwordConfirm
  }

  return fetcher('register', data, REGISTER)
}
