import { request } from '@/plugins/axios'

export default {
  addFavorite (toUserId) {
    return request('post', '/favorite/add', {
      toUserId,
    })
  },
  deleteFavorite (toUserId) {
    return request('delete', '/favorite/delete', {
      data: {
        toUserId,
      }
    })
  },
  addFavoriteFromMypage (toUserId) {
    return request('post', '/favorite/mypage/add', {
      toUserId,
    })
  },
  deleteFavoriteFromMypage (toUserId) {
    return request('delete', '/favorite/mypage/delete', {
      data: {
        toUserId,
      }
    })
  }
}