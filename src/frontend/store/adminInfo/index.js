export const state = () => ({
    admin: {
      login: 0
    }
})

export const getters = {
    login: (state) => {
      return state.admin.login
    }
}

export const mutations = {
    setAdminInfo(state, userInfo) {
        state.admin.login = userInfo
    }
}

export const actions = {
    setAdminInfo({ commit }, userInfo) {
        commit('setAdminInfo', userInfo)
    }
}
