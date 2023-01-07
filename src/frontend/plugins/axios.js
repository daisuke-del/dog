import constants from '~/utils/constants'
import { auth } from '~/plugins/auth'
import user from '~/plugins/modules/user'

let axios
export let cancel

const authenticationExclusionApi = [
  '/api/user/login',
  '/api/user/update/email/auth',
  '/api/user/update/password'
]

export default function ({ $axios, store, redirect }) {
  axios = $axios
  $axios.onResponse((response) => {
    return Promise.resolve(response)
  })

  $axios.onError((error) => {
    if (error && error.response) {
      if (error.response.status === 503 && error.response.headers.maintenancemode === 'true') {
        location.reload()
        return
      }
      const url = error.response.config.url
      if ((error.response.status === 401 || error.response.status === 409 || error.response.status === 503) && !authenticationExclusionApi.includes(url)) {
        redirect('/login')
        return
      }
    }
    if (error && error.response && error.response.data && error.response.data.error) {
      if (error.response.data.error_code === constants.errorCode.no_user) {
        store.dispatch('snackbar/setMessage', error.response.data.error)
        store.dispatch('snackbar/snackOn')
        user.logout()
        return Promise.reject(constants.errorCode.no_user)
      }
      if (showErrorMessage(error.response)) {
        store.dispatch('snackbar/setMessage', error.response.data.error)
        store.dispatch('snackbar/snackOn')
      }
    } else if (!$axios.isCancel(error)) {
      if (error && error.response) {
        if (showErrorMessage(error.response)) {
          store.dispatch('snackbar/setMessage', constants.errorMessage)
          store.dispatch('snackbar/snackOn')
          return
        }
      } else {
        store.dispatch('snackbar/setMessage', constants.errorMessage)
        store.dispatch('snackbar/snackOn')
      }
    }
    return Promise.reject(error)
  })
}

export async function request (method, url, data) {
  if (auth.loggedIn && !auth.strategy.token.status().valid()) {
    await auth.strategy.token.reset()
    await user.logout()
  }


  if (method === 'post') {
    return await axios.$post(url, data, { withCredentials: true })
  } else if (method === 'put') {
    return await axios.$put(url, data)
  } else if (method === 'delete') {
    return await axios.$delete(url, data)
  }

  return await axios.$get(url, { withCredentials: true })
}