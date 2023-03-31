import { request } from "~/plugins/axios";

export default {
  sliderImage( sex) {
    return request('post', '/api/slider/match', {
       sex
    })
  },
  signupSliderImage( sex, mail) {
    return request('post', '/api/slider/signup', {
      sex: sex,
      email: mail
    })
  }
}
