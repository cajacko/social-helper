import fetcher from '~/helpers/fetcher'
import * as actionTypes from '~/constants/actions'

export function deleteBlacklistItem(id, accountId) {
  const data = {
    id: id,
    accountId: accountId
  }

  return fetcher('blacklist/delete', data, actionTypes.BLACKLIST_ITEM_DELETE)
}

export function createBlacklistItem(query, accountId) {
  const data = {
    query: query,
    accountId: accountId
  }

  return fetcher('blacklist/create', data, actionTypes.BLACKLIST_ITEM_CREATE)
}
