import { request } from '../axios'

export default {
    getBreeds() {
        return request('get', '/api/breed/info')
    },
    getBreedInfo(breed) {
        return request('get', `/api/breed/detail/${breed}`)
    },
}