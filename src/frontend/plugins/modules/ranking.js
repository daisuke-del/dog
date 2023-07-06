import { request } from "~/plugins/axios";

export default {
    getRanking() {
        return request('get', '/api/ranking/get')
    },
    getRankingWithFriends() {
        return request('get', '/favorite/ranking')
    }
}