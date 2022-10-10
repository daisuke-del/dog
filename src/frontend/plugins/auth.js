export let auth

export default function ({ $auth }) {
  auth = $auth
  $auth.$storage.watchState('loggedIn', (isLoggedIn) => {
    window.$nuxt.$emit('updateAuth', isLog)
  })
}