import { request } from "~/plugins/axios";

export default {
  sliderImage() {
    return request('get', '/api/slider')
  },
  signupSliderImage(mail) {
    return request('post', '/api/slider/signup', {
      email: mail
    })
  }
}
