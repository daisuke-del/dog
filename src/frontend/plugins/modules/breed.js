import { request } from '../axios'

export default {
    getBreeds() {
        return request('get', '/api/breed/info')
    },
    getBreedsRandom() {
        return request('get', '/api/breed/random')
    },
    getBreedInfo(breed) {
        return request('get', `/api/breed/detail/${breed}`)
    },
    getBreedsSort(size, group, country) {
        return request('post', '/api/breed/sort', {
            size,
            group,
            country
        })
    }
}