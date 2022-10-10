export const state = () => ({
  match: {
    gender: null,
    age: null,
    height: null,
    weight: null,
    salary: null,
    face: null,
    place: null
  }
})

export const getter = {
  match: (state) => {
    return state.match
  }
}

export const mutations = {
  setMatch (state, match) {
    state.match.gender = match.gender
    state.match.age = match.age
    state.match.height = match.height
    state.match.weight = match.weight
    state.match.salary = match.salary
    state.match.face = match.face
    state.match.place = match.place
  },
  deleteMatch (state) {
    state.match.gender = null
    state.match.age = null
    state.match.height = null
    state.match.weight = null
    state.match.salary = null
    state.match.face = null
    state.match.place = null
  }
}

export const actions = {
  setMatch ({ commit }) {
    commit('setMatch')
  },
  
}