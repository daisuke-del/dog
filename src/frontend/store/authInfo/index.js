import user from "@/plugins/modules/user"

export const state = () => ({
  auth: {
    userId: null,
    name: null,
    email: null,
    password: null,
    dogImage1: 'no-user-image-icon.png',
    dogImage2: null,
    dogImage3: null,
    weight: null,
    dogPoint: null,
    updateDogAt: null,
    twitterId: null,
    instagramId: null,
    tiktokId: null,
    blogId: null,
    location: null,
    birthday: null,
    breed1: null,
    breed2: null,
    voidFlg: 0,
  },
})

export const getters = {
  auth: (state) => {
    return state.auth
  },
  userId: (state) => {
    return state.auth.userId
  },
  dogImage1: (state) => {
    return state.auth.dogImage1
  },
  dogImage2: (state) => {
    return state.auth.dogImage2
  },
  dogImage3: (state) => {
    return state.auth.dogImage3
  }
}

export const mutations = {
  setAuthInfo(state, userInfo) {
    state.auth.userId = userInfo.user_id
    state.auth.name = userInfo.name ? userInfo.name : ''
    state.auth.dogImage1 = userInfo.dog_image1 ? userInfo.dog_image1 : 'no-user-image-icon.png'
    state.auth.dogImage2 = userInfo.dog_image2 ? userInfo.dog_image2 : null
    state.auth.dogImage3 = userInfo.dogImage3 ? userInfo.dog_image3 : null
    state.auth.dogPoint = userInfo.dog_point
    state.auth.location = userInfo.location
    state.auth.birthday = userInfo.birthday
    state.auth.breed1 = userInfo.breed1
    state.auth.breed2 = userInfo.breed2 ? userInfo.breed2 : null
    state.auth.voidFlg = userInfo.void_flg ? userInfo.void_flg : 0
  },
  setEmail(state, email) {
    state.auth.email = email
  },
  setName(state, name) {
    state.auth.name = name
  },
  setWeight(state, weight) {
    state.auth.weight = weight
  },
  setInstagramId(state, instagramId) {
    state.auth.instagramId = instagramId
  },
  setTwitterId(state, twitterId) {
    state.auth.twitterId = twitterId
  },
  setTiktokId(state, tiktokId) {
    state.auth.tiktokId = tiktokId
  },
  setBlogId(state, blogId) {
    state.auth.blogId = blogId
  },
  setLocation(state, location) {
    state.auth.location = location
  },
  setLocation(state, birthday) {
    state.auth.birthday = birthday
  },
  setBreed1(state, breed1) {
    state.auth.breed1 = breed1
  },
  setBreed2(state, breed2) {
    state.auth.breed1 = breed2
  }
}

export const actions = {
  setAuthInfo({ commit }, userInfo) {
    commit('setAuthInfo', userInfo)
  },
  setEmail({ commit }, email) {
    commit('setEmail', email)
  },
  setName({ commit }, name) {
    commit('setName', name)
  },
  setWeight({ commit }, weight) {
    commit('setWeight', weight)
  },
  setInstagramId({ commit }, instagramId) {
    commit('setInstagramId', instagramId)
  },
  setTwitterId({ commit }, twitterId) {
    commit('setTwitterId', twitterId)
  },
  setTiktokId({ commit }, tiktokId) {
    commit('setTiktokId', tiktokId)
  },
  setBlogId({ commit }, blogId) {
    commit('setBlogId', blogId)
  },
  setLocation({ commit }, location) {
    commit('setLocation', location)
  },
  setBirthday({ commit }, birthday) {
    commit('setBirthday', birthday)
  },
  setBreed1({ commit }, breed1) {
    commit('setBreed1', breed1)
  },
  setBreed2({ commit }, breed2) {
    commit('setBreed2', breed2)
  },
  async setUserStatus ({ commit }) {
    if (this.$auth.loggedIn) {
      await user.getUserInfo().then((response) => {
        commit('setAuthInfo', response)
      })
    }
  }
}
