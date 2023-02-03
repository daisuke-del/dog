export const state = () => ({
  auth: {
    userId: null,
    name: null,
    email: null,
    password: null,
    faceImage: 'no-user-image-icon.jpeg',
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
    score: 'N',
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
  gender: (state) => {
    return state.auth.gender
  }
}

export const mutations = {
  setAuthInfo(state, userInfo) {
    state.auth.userId = userInfo.user_id
    state.auth.gender = userInfo.gender ? userInfo.gender : null
    state.auth.name = userInfo.name ? userInfo.name : '名無しさん'
    state.auth.faceImage = userInfo.face_image ? userInfo.face_image : 'no-user-image-icon.jpeg'
    state.auth.facePoint = userInfo.face_point ? userInfo.face_point : 0
    state.auth.rank = userInfo.rank ? userInfo.rank : 'Nomal'
    state.auth.score = userInfo.score ? userInfo.score : 'N'
    state.auth.voidFlg = userInfo.void_flg ? userInfo.void_flg : 0
  },
}

export const actions = {
  setAuthInfo({ commit }, userInfo) {
    commit('setAuthInfo', userInfo)
  },
}
