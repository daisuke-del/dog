import { request } from '@/plugins/axios'

export default {
  result (match) {
    return request('post', '/api/match/result', {
      match
    })
  },
  choice (upUser, downUser, gender) {
    return request('post', '/api/match/choice', {
      upUser,
      downUser,
      gender
    })
  },
  alert (userId) {
    return request('post', '/api/match/alert', {
      userId
    })
  }
}