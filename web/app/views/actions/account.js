import fetcher from '~/helpers/fetcher'
import * as actionTypes from '~/constants/actions'

export function deleteAccount(id) {
  const data = {
    id: id
  }

  return fetcher('account/delete', data, actionTypes.ACCOUNT_DELETE)
}

export function updateCron(accountId, cron) {
  const data = {
    cron: cron,
    accountId: accountId
  }

  return fetcher('cron/update', data, actionTypes.CRON_UPDATE)
}
