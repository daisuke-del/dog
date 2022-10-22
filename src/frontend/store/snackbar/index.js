export const state = () => ({
  isEnable: false,
  message: false
})

export const getters = {
  status: (state) => {
    return state.isEnable
  },
  message: (state) => {
    return state.message
  }
}

export const mutations = {
  setEnable (state) {
    state.isEnable = true
  },
  setDisable (state) {
    state.isEnable = false
  },
  setMessage (state, message) {
    state.message = message
  }
}

export const actions = {
  snackOn ({ commit }) {
    commit('setEnable')
  },
  snackOff ({ commit }) {
    commit('setDisable')
  },
  setMessage ({ commit }, message) {
    commit('setMessage', message)
  }
}