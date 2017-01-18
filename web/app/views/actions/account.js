import fetcher from '~/helpers/fetcher'
import * as actionTypes from '~/constants/actions'

export function deleteAccount(id) {
  const data = {
    id: id
  }

  return fetcher('account/delete', data, actionTypes.ACCOUNT_DELETE)
}
