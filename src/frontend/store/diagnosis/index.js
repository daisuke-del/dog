export const state = () => ({
  diagnosis: {
    age: null,
    height: null,
    weight: null,
    salary: null,
    face: null,
    friendly: null,
    earnest: null,
    sociable: null,
    place: null
  }
})

export const getters = {
  diagnosis: (state) => {
    return state.diagnosis
  }
}

export const mutations = {
  setDiagnosis (state, diagnosis) {
    state.diagnosis.sex = diagnosis.sex
    state.diagnosis.age = diagnosis.age
    state.diagnosis.height = diagnosis.height
    state.diagnosis.weight = diagnosis.weight
    state.diagnosis.salary = diagnosis.salary
    state.diagnosis.face = diagnosis.face,
    state.diagnosis.friendly = diagnosis.friendly
    state.diagnosis.earnest = diagnosis.earnest
    state.diagnosis.sociable = diagnosis.sociable
    state.diagnosis.place = diagnosis.place
  },
  deleteDiagnosis (state) {
    state.diagnosis.sex = null
    state.diagnosis.age = null
    state.diagnosis.height = null
    state.diagnosis.weight = null
    state.diagnosis.salary = null
    state.diagnosis.face = null
    state.diagnosis.friendly = null
    state.diagnosis.earnest = null
    state.diagnosis.sociable = null
    state.diagnosis.place = null
  }
}

export const actions = {
  setDiagnosis ({ commit }, diagnosis) {
    commit('setDiagnosis', diagnosis)
  }
}