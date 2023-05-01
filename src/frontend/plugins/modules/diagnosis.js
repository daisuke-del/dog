import { request } from '@/plugins/axios'

export default {
  result ( gender, height, weight, personality1, personality2, personality3, face, holiday) {
    return request('post', '/api/diagnosis/result', {
      gender,
      height,
      weight,
      personality1,
      personality2,
      personality3,
      face,
      holiday
    })
  },
  choice (upDog, downDog) {
    return request('post', '/api/diagnosis/choice', {
      upDog,
      downDog,
    })
  },
  alert (userId) {
    return request('post', '/api/diagnosis/alert', {
      userId
    })
  }
}