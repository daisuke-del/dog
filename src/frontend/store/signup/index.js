export const state = () => ({
  signup: {
    name: null,
    email: null,
    password: null,
    dogImage: null,
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
    agree: false
  }
})

export const getters = {
  signup: (state) => {
    return state.signup
  }
}

export const mutations = {
  setRegisterInfo (state, signup) {
    state.signup.name = signup.name
    state.signup.email = signup.email
    state.signup.password = signup.password
    state.signup.sex = signup.sex
    state.signup.age = signup.age
    state.signup.height = signup.height
    state.signup.weight = signup.weight
    state.signup.salary = signup.salary
    state.signup.agree = signup.agree
  },
  setDogImage (state, signup) {
    state.signup.dogImage = signup.dogImage
  },
  setDogPoint (state, signup) {
    state.signup.dogPoint = signup.dogPoint
  },
  setAuthCode (state, signup) {
    state.signup.authCode = signup.authCode
  }
}

export const actions = {
  setSignup ({ commit }, signup) {
    commit('setSignup', signup)
  },
  setDogImage ({ commit }, signup) {
    commit('setDogImage', signup)
  },
  setDogPoint ({ commit }, signup) {
    commit('setDogPoint', signup)
  },
  setAuthCode ({ commit }, signup) {
    commit('setAuthCode', signup)
  }
}