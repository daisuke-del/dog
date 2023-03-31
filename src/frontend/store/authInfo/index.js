export const state = () => ({
  auth: {
    userId: null,
    name: null,
    email: null,
    password: null,
    dogImage: 'no-user-image-icon.jpeg',
    sex: null,
    age: null,
    height: null,
    weight: null,
    salary: null,
    dogPoint: null,
    updateDogAt: null,
    twitterId: null,
    instagramId: null,
    facebookId: null,
    score: 'D',
    rank: 'Nomal',
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
  sex: (state) => {
    return state.auth.sex
  },
  dogImage: (state) => {
    return state.auth.dogImage
  }
}

export const mutations = {
  setAuthInfo(state, userInfo) {
    state.auth.userId = userInfo.user_id
    state.auth.sex = userInfo.sex ? userInfo.sex : null
    state.auth.name = userInfo.name ? userInfo.name : '名無しさん'
    state.auth.dogImage = userInfo.dog_image ? userInfo.dog_image : 'no-user-image-icon.jpeg'
    state.auth.dogPoint = userInfo.dog_point ? userInfo.dog_point : 0
    state.auth.rank = userInfo.rank ? userInfo.rank : 'Nomal'
    state.auth.score = userInfo.score ? userInfo.score : 'D'
    state.auth.voidFlg = userInfo.void_flg ? userInfo.void_flg : 0
  },
  setEmail(state, email) {
    state.auth.email = email
  },
  setName(state, name) {
    state.auth.name = name
  },
  setHeight(state, height) {
    state.auth.height = height
  },
  setWeight(state, weight) {
    state.auth.weight = weight
  },
  setAge(state, age) {
    state.auth.age = age
  },
  setSalary(state, salary) {
    state.auth.salary = salary
  },
  setFacebookId(state, facebookId) {
    state.auth.facebookId = facebookId
  },
  setInstagramId(state, instagramId) {
    state.auth.instagramId = instagramId
  },
  setTwitterId(state, twitterId) {
    state.auth.twitterId = twitterId
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
  setHeight({ commit }, height) {
    commit('setHeight', height)
  },
  setWeight({ commit }, weight) {
    commit('setWeight', weight)
  },
  setAge({ commit }, age) {
    commit('setAge', age)
  },
  setSalary({ commit }, salary) {
    commit('setSalary', salary)
  },
  setFacebookId({ commit }, facebookId) {
    commit('setFacebookId', facebookId)
  },
  setInstagramId({ commit }, instagramId) {
    commit('setInstagramId', instagramId)
  },
  setTwitterId({ commit }, twitterId) {
    commit('setTwitterId', twitterId)
  }
}
