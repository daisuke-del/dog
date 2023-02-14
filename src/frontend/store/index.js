import user from '@/plugins/modules/user'

const cookieparser = process.server ? require('cookieparser') : undefined

export const actions = {
  async nuxtServerInit({ commit }, { req }) {
    cookieparser.parse(req.headers.cookie)

    await user.getUserInfo().then((response) => {
        commit('authInfo/setAuthInfo', response)
    }).catch((error) => {
        console.log(error)
        commit('authInfo/setAuthInfo', null)
      })
  },
}