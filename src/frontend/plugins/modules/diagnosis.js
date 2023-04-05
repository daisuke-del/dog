import { request } from '@/plugins/axios'

export default {
  result ( sex, height, weight, age, salary, dogPoint, place) {
    return request('post', '/user/match/result', {
      sex,
      height,
      weight,
      age,
      salary,
      dogPoint,
      place
    })
  },
  choice (upUser, downUser, sex) {
    return request('post', '/api/match/choice', {
      upUser,
      downUser,
       sex
    })
  },
  alert (userId, sex) {
    return request('post', '/api/match/alert', {
      userId,
       sex
    })
  }
}