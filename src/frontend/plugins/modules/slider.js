// import { request } from "../axios";
import { auth } from "../auth";
import {request} from "~/plugins/axios";

export default {
  signupSliderImage(mail) {
    return request('post', '/api/slider/signup', {
      email: mail
    })
  }
}
