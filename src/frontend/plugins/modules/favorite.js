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
  }
}