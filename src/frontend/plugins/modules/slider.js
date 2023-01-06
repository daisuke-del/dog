import { request } from "~/plugins/axios";

export default {
  sliderImage(gender) {
    return request('post', '/api/slider/match', {
      gender
    })
  },
  signupSliderImage(gender, mail) {
    return request('post', '/api/slider/signup', {
      gender: gender,
      email: mail
    })
  }
}
