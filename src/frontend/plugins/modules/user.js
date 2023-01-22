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
    return request('get', '/api/my')
  },
  updateFaceImage() {
    return request('put', '/api/update/face')
  }
}
