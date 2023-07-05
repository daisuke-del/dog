import { request } from '../axios'
import { auth } from '../auth'

export default {
  login (email, password) {
    return auth.loginWith('login', {
      data: {
        email,
        password,
      },
    })
  },
  async logout() {
    return await auth.logout()
  },
  signup (
    sex,
    name,
    email,
    password,
    weight,
    breed1,
    breed2,
    instagramId,
    twitterId,
    tiktokId,
    blogId,
    dogImage,
    location,
    birthday
  ) {
    return auth.loginWith('signUp', {
      data: {
        sex,
        name,
        email,
        password,
        weight,
        breed1,
        breed2,
        instagramId,
        twitterId,
        tiktokId,
        blogId,
        dogImage,
        location,
        birthday
      },
    })
  },
  leave () {
    return request('post', '/user/leave')
  },
  getUserInfo () {
    return request('get', '/user/my')
  },
  checkEmail (email) {
    return request('post', '/api/check/email', {
      email,
    })
  },
  updateEmail (email, password) {
    return request('post', '/update/email', {
      email,
      password,
    })
  },
  updateName (name) {
    return request('post', '/update/name', {
      name,
    })
  },
  updateWeight (weight) {
    return request('post', '/update/weight', {
      weight,
    })
  },
  updateBreed (breed1, breed2) {
    return request('post', '/update/breed', {
      breed1,
      breed2
    })
  },
  updateBirthday (year, month, day) {
    return request('post', '/update/birthday', {
      year,
      month,
      day
    })
  },
  updateLocation (location) {
    return request('post', '/update/location', {
      location
    })
  },
  updateDogImage (dogImage, num) {
    return request('post', '/update/image', {
      dogImage,
      num
    })
  },
  updateInstagram (instagram) {
    return request('post', '/update/instagram', {
      instagram,
    })
  },
  updateTwitter (twitter) {
    return request('post', '/update/twitter', {
      twitter,
    })
  },
  updateTiktok (tiktok) {
    return request('post', '/update/tiktok', {
      tiktok
    })
  },
  updateBlog (blog) {
    return request('post', '/update/blog', {
      blog
    })
  },
  getUsersRandom () {
    return request('get', '/api/user/random')
  },
  getUsersRandomWithFriends () {
    return request('get', '/favorite/random')
  },
  getUsers (offset) {
    return request('get', `/api/user/${offset}`)
  },
  getUsersWithFriends (offset) {
    return request('get', `/user/dog/friend/${offset}`)
  },
  getChoiceUsers () {
    return request('get', '/api/user/two')
  }
}
