import { request } from "../axios";
import { auth } from "../auth";

export default {
  async login (mail, pass) {
    return await auth.loginWith('login', {
      data: {
        email: mail,
        password: pass
      }
    })
  },
  async logout () {
    return await auth.logout()
  },
  signup (mail, pass) {
    return request('post', '/api/user/signup', {
      email: mail,
      password: pass
    })
  },
  async auth (authCode) {
    return await auth.loginWith('signup', {
      data: {
        auth_code: authCode
      }
    })
  },
  foregetPasswordEmail (mail) {
    return request('post', '/api/user/forget/password/email', {
      email: mail
    })
  },
  foregetPasswordAuth (authCode) {
    return request('post', '/api/user/foreget/password/auth', {
      auth_code: authCode
    })
  },
  foregetPasswordUpdate (pass, confirmation) {
    return request('put', '/api/user/foreget/password/update', {
      password: pass,
      password_again: confirmation
    })
  },
  getUserInfo () {
    return request('get', '/api/my')
  },
  updateEmail (mail) {
    return request('put', '/api/user/update/email', {
      email: mail
    })
  },
  updateEmailAuth (password, email, authCode) {
    return request('put', '/api/user/update/email/auth', {
      password,
      email,
      auth_code: authCode
    })
  },
  updatePassword (currentPassword, newPassword, newPasswordAgain) {
    return request('put', '/api/user/update/password', {
      password: currentPassword,
      new_password: newPassword,
      new_password_again: newPasswordAgain
    })
  },
  updateHandleName (name) {
    return request('put', '/api/user/update/name', {
      handle_name: name
    })
  }
}