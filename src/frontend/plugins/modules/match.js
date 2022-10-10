import { request } from '../axios'
// import { auth } from '../auth'

export default {
  gender (gender){
    console.log(gender)
    return request('post', 'http://127.0.0.1:8000/api/match/gender', {
      gender
    })
  }
}