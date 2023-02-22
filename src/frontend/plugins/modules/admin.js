import { request } from '../axios'
import { auth } from '../auth'

export default {
  login(email, password) {
    return auth.loginWith('admin', {
      data: {
        email,
        password,
      },
    })
  },
  async logout() {
    return await auth.logout()
  },
  getInfo() {
    return request('get', '/admin/info')
  },
  deleteVoidImage(userId) {
    return request('post', '/admin/delete', {
      userId
    })
  },
  updateYellowCard(userId) {
    return request('post', '/admin/update', {
      userId
    })
  }
}
