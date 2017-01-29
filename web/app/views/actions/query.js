import fetcher from '~/helpers/fetcher'
import * as actionTypes from '~/constants/actions'

export function deleteQuery(queryId, accountId) {
  const data = {
    queryId: queryId,
    accountId: accountId
  }

  return fetcher('query/delete', data, actionTypes.QUERY_DELETE)
}

export function createQuery(query, accountId) {
  const data = {
    query: query,
    accountId: accountId
  }

  return fetcher('query/create', data, actionTypes.QUERY_CREATE)
}
