import { request } from "~/plugins/axios";

export default {
    getRanking() {
        return request('get', '/api/ranking/get')
    },
    getRankingWishFriends() {
        return request('get', '/favorite/ranking')
    }
}