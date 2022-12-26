// import { request } from "../axios";
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
  async signup (gender, name, email, password, height, weight, age, salary, faceImage, facePoint) {
    return await auth.loginWith('signUp', {
      data: {
        gender, name, email, password, height, weight, age, salary, faceImage, facePoint
      }
    })
  }
}
