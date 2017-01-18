import fetcher from '~/helpers/fetcher'
import * as actionTypes from '~/constants/actions'

export function updateQuery(id, query) {
  const data = {
    id: id,
    query: query
  }

  return fetcher('query/update', data, actionTypes.QUERY_UPDATE)
}

export function deleteQuery(id) {
  const data = {
    id: id
  }

  return fetcher('query/delete', data, actionTypes.QUERY_DELETE)
}

export function createQuery(query) {
  const data = {
    query: query
  }

  return fetcher('query/create', data, actionTypes.QUERY_CREATE)
}
