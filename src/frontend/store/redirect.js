export const state = () => ({
  pageUrl: null
})

export const mutations = {
  setPageUrl (state, url) {
    state.pageUrl = url
  }
}

export const actions = {
  addPageUrl ({ commit }, url) {
    commit('setPageUrl', url)
  },
  deletePageUrl ({ commit }) {
     commit('setPageUrl', null)
  }
}