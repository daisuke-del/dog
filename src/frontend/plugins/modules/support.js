import { request } from '@/plugins/axios'

export default {
  send (name, email, item, content) {
    return request('post', '/api/support/send', {
      name,
      email,
      item,
      content
    })
  },
  resolve (id) {
    return request('post', '/api/support/resolve', {
      id
    })
  }
}