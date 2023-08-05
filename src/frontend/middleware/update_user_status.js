import user from "@/plugins/modules/user"

export default function ({ app }) {
  if (app.$auth.loggedIn) {
    user.getUserInfo().then((response) => {
      app.store.dispatch('authInfo/setAuthInfo', response)
    })
  }
}
