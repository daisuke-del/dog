// import { request } from "../axios";
import { auth } from "../auth";

export default {
  async login (email, password) {
    return await auth.loginWith('login', {
      data: {
        email,
        password
      }
    })
  },
  async logout () {
    return await auth.logout()
  },
  async signup (gender, name, email, password, height, weight, age, salary, facePoint, faceImage) {
    return await auth.loginWith('signUp', {
      data: {
        gender, name, email, password, height, weight, age, salary, facePoint, faceImage
      }
    })
  }
}
