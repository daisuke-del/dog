import { request } from '@/plugins/axios'

export default {
  addFavorite (toUserId, fromUserId) {
    return request('post', '/favorite/add', {
      toUserId,
      fromUserId
    })
  },
  deleteFavorite (toUserId, fromUserId) {
    return request('delete', '/favorite/delete', {
      data: {
        toUserId,
        fromUserId
      }
    })
  }
}