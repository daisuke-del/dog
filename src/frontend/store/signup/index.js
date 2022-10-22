export const state = () => ({
  signup: {
    name: null,
    email: null,
    password: null,
    faceImage: null,
    gender: null,
    age: null,
    height: null,
    weight: null,
    salary: null,
    facePoint: null,
    updateFaceAt: null,
    twitterId: null,
    instagramId: null,
    facebookId: null,
    authCode: null,
    emailConfirmFlg: 0,
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
    state.signup.gender = signup.gender
    state.signup.age = signup.age
    state.signup.height = signup.height
    state.signup.weight = signup.weight
    state.signup.salary = signup.salary
    state.signup.agree = signup.agree
  },
  setFaceImage (state, signup) {
    state.signup.faceImage = signup.faceImage
  },
  setFacePoint (state, signup) {
    state.signup.facePoint = signup.facePoint
  },
  setAuthCode (state, signup) {
    state.signup.authCode = signup.authCode
  }
}

export const actions = {
  setSignup ({ commit }, signup) {
    commit('setSignup', signup)
  },
  setFaceImage ({ commit }, signup) {
    commit('setFaceImage', signup)
  },
  setFacePoint ({ commit }, signup) {
    commit('setFacePoint', signup)
  },
  setAuthCode ({ commit }, signup) {
    commit('setAuthCode', signup)
  }
}