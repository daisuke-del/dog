import { request } from '../axios'

export default {
  runCode(id, code) {
    return request('post', '/api/escape/solve', {
      id,
      code
    })
  }
}