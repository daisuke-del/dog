import { request } from '@/plugins/axios'

export default {
  result (gender, height, weight, age, salary, facePoint, place) {
    return request('post', '/api/match/result', {
      gender,
      height,
      weight,
      age,
      salary,
      facePoint,
      place
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