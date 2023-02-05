import { request } from "../axios";
import { auth } from "../auth";

export default {
  login (email, password) {
    return auth.loginWith('login', {
      data: {
        email,
        password
      }
    })
  },
  async logout () {
    return await auth.logout()
  },
  signup (gender, name, email, password, height, weight, age, salary, facePoint, faceImage) {
    return auth.loginWith('signUp', {
      data: {
        gender, name, email, password, height, weight, age, salary, facePoint, faceImage
      }
    })
  },
  getUserInfo() {
    return request('get', '/user/my')
  },
  checkEmail(email) {
    return request('post', '/api/check/email', {
      email
    })
  },
  updateEmail(email, password) {
    return request('post', '/update/email', {
      email,
      password
    })
  },
  updateName(name) {
    return request('post', '/update/name', {
      name
    })
  },
  updateHeight(height) {
    return request('post', '/update/height', {
      height
    })
  },
  updateWeight(weight) {
    return request('post', '/update/weight', {
      weight
    })
  },
  updateAge(age) {
    return request('post', '/update/age', {
      age
    })
  },
  updateSalary(salary, salary2) {
    return request('post', '/update/salary', {
      salary,
      salary2
    })
  },
  updateFacebook(facebook) {
    return request('post', '/update/facebook', {
      facebook
    })
  },
  updateInstagram(instagram) {
    return request('post', '/update/instagram', {
      instagram
    })
  },
  updateTwitter(twitter) {
    return request('post', '/update/twitter', {
      twitter
    })
  },
  updateFaceImage() {
    return request('put', '/user/update/face')
  },
}
