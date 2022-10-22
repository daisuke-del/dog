import { request } from '../axios'
// import { auth } from '../auth'

export default {
  result (match) {
    return request('post', '/api/match/result', {
      match
    })
  },
  choice (user) {
    return request('post', '/api/match/choice', {
      user
    })
  },
  slider () {
    return request('get', '/api/match/slider')
  }
}