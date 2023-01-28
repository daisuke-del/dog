<template>
  <div class="all">
    <div class="main-all">
      <h1>{{ title }}</h1>
      <common-cropperjs v-show="modalCropper" @close-image-modal="closeModalCrop" @save-crop-image="saveCropImage" />
      <common-modal :modalUser="modalUser" v-show="modal" @summary-method="summaryMethod" />
      <div class="main-wrap">
        <p class="name-text">{{ name }}</p>
        <v-row>
          <v-col cols="6">
            <v-card light class="face-card">
              <div class="image-wrap">
                <v-img :src="require(`@/../storage/image/faceimages/${faceImage}`)" />
                <v-btn class="image-icon" elevation="5" fab small @click="modalCroppers">
                  <v-icon color="white"> mdi-image-size-select-actual </v-icon>
                </v-btn>
              </div>
            </v-card>
          </v-col>
          <v-col cols="6">
            <v-card light class="my-card">
              <div class="info-wrap">
                <p class="big-text">総合ランク</p>
                <div class="rank-wrap">
                  <v-img v-if="facePoint > 80 && score === 'A'" :src="require('~/assets/image/rank/gold.png')"
                    class="rank-icon" contain />
                  <v-img v-else-if="facePoint > 50 && score === 'B'" :src="require('~/assets/image/rank/silver.png')"
                    class="rank-icon" contain />
                  <v-img v-else-if="score !== 'C'" :src="require('~/assets/image/rank/blond.png')" class="rank-icon"
                    contain />
                  <v-img v-else :src="require('~/assets/image/rank/nomal.png')" class="rank-icon" contain />
                </div>
                <div class="point-wrap d-flex justify-center">
                  <p class="point-text">Lv.
                    <span v-if="facePoint > 90" class="text-S">
                      {{ facePoint }}
                    </span>
                    <span v-else-if="facePoint > 70" class="text-A">
                      {{ facePoint }}
                    </span>
                    <span v-else-if="facePoint > 50" class="text-B">
                      {{ facePoint }}
                    </span>
                    <span v-else-if="facePoint > 30" class="text-C">
                      {{ facePoint }}
                    </span>
                    <span v-else class="text-D">
                      {{ facePoint }}
                    </span>
                    /
                    <span v-if="score === 'S'" class="text-S">
                      {{ score }}
                    </span>
                    <span v-else-if="score === 'A'" class="text-A">
                      {{ score }}
                    </span>
                    <span v-else-if="score === 'B'" class="text-B">
                      {{ score }}
                    </span>
                    <span v-else-if="score === 'C'" class="text-C">
                      {{ score }}
                    </span>
                    <span v-else class="text-D">
                      {{ score }}
                    </span>
                  </p>
                </div>
              </div>
            </v-card>
          </v-col>
        </v-row>
      </div>
      <v-row>
        <v-col cols="12" class="list-all">
          <p class="small-text mb-1">フレンドリスト</p>
          <v-sheet light class="mx-auto" elevation="2">
            <v-slide-group v-model="model" active-class="success" show-arrows>
              <v-slide-item v-for="(friend, index) in friends" :key="index">
                <v-card class="mt-3 mb-3 mr-2" height="150" width="130">
                  <v-row>
                    <v-col>
                      <v-img :src="require(`@/../storage/image/faceimages/${friend['face_image']}`)" contain rounded
                        @click="showProfile(friend)" />
                      <p class="card-summary-text ml-2">{{ friend['name'] }}</p>
                      <v-btn class="delete-icon" elevation="5" fab height="20px" width="20px" color="primary"
                        @click="clickNotFavorite(friend['user_id'], friend['name'], index)">
                        <v-icon small dark> mdi-close-thick </v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-card>
              </v-slide-item>
            </v-slide-group>
          </v-sheet>
          <p v-if="friends.length === 0" class="not-friend mt-5">現在フレンドはいません</p>
          <div class="btn-wrap">
            <v-btn v-if="isShowFriend" class="small-text show-friend-btn mt-8" light
              @click="isShowFriend = !isShowFriend">
              閉じる
            </v-btn>
            <v-btn v-else class="small-text show-friend-btn mt-8" light @click="isShowFriend = !isShowFriend">
              全てのフレンド
            </v-btn>
          </div>
        </v-col>
      </v-row>
      <v-row v-show="isShowFriend">
        <v-col v-for="(friend, index) in friends" :key="index" cols="6" sm="3" lg="2" class="d-flex justify-center">
          <v-card light width="200px">
            <v-img :src="require(`@/../storage/image/faceimages/${friend['face_image']}`)" width="200px" contain rounded
              @click="showProfile(friend)" />
            <p class="card-summary-text">{{ friend['name'] }}</p>
            <div class="icon-wrap">
              <v-btn icon class="sns-icon" :disabled="!friend['twitter_id']">
                <v-icon color="#1DA1F2"> mdi-twitter </v-icon>
              </v-btn>
              <v-btn icon class="sns-icon" :disabled="!friend['instagram_id']">
                <v-icon color="#C13584"> mdi-instagram </v-icon>
              </v-btn>
              <v-btn icon class="sns-icon" :disabled="!friend['facebook_id']">
                <v-icon color="#4267B2"> mdi-facebook </v-icon>
              </v-btn>
            </div>
            <v-btn class="delete-icon" elevation="5" fab height="20px" width="20px" color="primary"
              @click="clickNotFavorite(friend['user_id'], friend['name'], index)">
              <v-icon small dark> mdi-close-thick </v-icon>
            </v-btn>
          </v-card>
        </v-col>
        <v-col cols="12">
          <p v-if="friends.length === 0" class="not-friend">現在フレンドはいません</p>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
import CommonModal from '@/components/Common/Modal'
import CommonCropperjs from '@/components/Common/Cropper'
import user from '@/plugins/modules/user'
import favorite from '@/plugins/modules/favorite'
export default {
  components: {
    CommonModal,
    CommonCropperjs
  },
  name: 'MyPage',
  async asyncData({ app }) {
    let userId = null
    let gender = null
    let name = null
    let rank = 'nomal'
    let faceImage = 'no-user-image-icon.jpeg'
    let facePoint = 0
    let score = 'E'
    let voidFlg = 0
    let friends = []
    await user.getUserInfo().then((response) => {
      console.log('userInfo', response)
      app.store.dispatch('authInfo/setAuthInfo', response)
      userId = response['user_id']
      gender = response['gender']
      name = response['name']
      rank = response['rank'] ? response['rank'] : 'nomal'
      faceImage = response['face_image'] ? response['face_image'] : 'no-user-image-icon.jpeg'
      facePoint = response['face_point'] ? response['face_point'] : 0
      score = response['score'] ? response['score'] : 'E'
      voidFlg = response['face_image_void_flg'] ? response['face_image_void_flg'] : 0
      friends = response['friends']
    })

    return {
      userId,
      gender,
      name,
      rank,
      faceImage,
      facePoint,
      score,
      voidFlg,
      friends
    }
  },
  data() {
    return {
      title: 'マイページ',
      model: null,
      modal: false,
      modalfile: false,
      message: 'よろしいですか？',
      num: null,
      isShowFriend: false,
      modalCropper: false,
      modalUser: {
        name: '名無しさん',
        faceImage: '99.jpeg',
        salary: '100',
        height: '150',
        facebookId: null,
        instagramId: null,
        twitterId: null
      },
      userId: null,
      gender: null,
      name: '名無しさん',
      rank: 'nomal',
      faceImage: 'no-user-image-icon.jpeg',
      facePoint: 0,
      score: 'E',
      voidFlg: 0,
      friends: []
    }
  },
  props: {
    msg: String,
  },
  methods: {
    modalCroppers() {
      this.modalCropper = true
    },
    showProfile(userInfo) {
      this.modalUser = {
        name: userInfo['name'],
        faceImage: userInfo['face_image'],
        salary: userInfo['salary'],
        height: userInfo['height'],
        facebookId: userInfo['facebook_id'] ? userInfo['facebook_id'] : null,
        instagramId: userInfo['instagram_id'] ? userInfo['instagram_id'] : null,
        twitterId: userInfo['twitter_id'] ? userInfo['twitter_id'] : null
      }
      this.modal = true
    },
    summaryMethod(status) {
      this.modal = status
    },
    closeModalCrop() {
      this.modalCropper = false
    },
    saveCropImage() {
      if (confirm('写真を変更すると継続スコアがリセットされます。\n変更しますか？')) {
        this.modalCropper = false
        // face_imageとupdate_at を更新
        user.updateFaceImage()
      }
    },
    clickNotFavorite(toUserId, userName, index) {
      if (confirm(userName + 'のお気に入りを解除してもいいですか？')) {
        favorite.deleteFavorite(toUserId, this.$store.getters['authInfo/userId']).then((response) => {
          console.log(response)
          this.friends.splice(index, 1)
        })
      }
    }
  },
}
</script>

<style scoped>
h1 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  margin: 10px;
  text-align: center;
}

.all {
  padding: 10px 10px 30px 10px;
  min-width: 350px;
  max-width: 650px;
  align-items: center;
  margin: 0 auto;
}

.name-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: dimgrey;
  font-weight: bolder;
  margin: 5px 0;
}

.face-card {
  max-width: 300px;
  display: block;
}

.image-wrap {
  position: relative;
}

.image-icon {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  bottom: -5%;
  right: -5%;
  background: url('~/assets/image/icons/icon60.png');
  background-size: contain;
}

.delete-icon {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  bottom: -5%;
  right: -5%;
  background: url('~/assets/image/icons/icon20.png') no-repeat;
  background-size: contain;
}

.my-card {
  max-width: 300px;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.point-wrap {
  text-align: center;
}

.big-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: dimgrey;
  font-weight: bolder;
  text-align: center;
  margin-bottom: 0;
}

.small-text {
  font-size: 0.75em;
  font-weight: bolder;
  font-family: 'Noto Sans JP', sans-serif;
  color: dimgrey;
}

.point-text {
  font-size: 1.2em;
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  font-weight: bolder;
  margin: 5px;
}

.rank-icon {
  height: 85px
}

.card-summary-text {
  font-size: 0.75em;
  font-weight: bolder;
  font-family: 'Noto Sans JP', sans-serif;
  padding-bottom: 0;
  margin-bottom: 0;
  color: dimgrey;
}

.btn-wrap {
  text-align: center;
}

.sns-icon {
  margin-right: 0 5px;
}

.text-S {
  color: purple;
}

.text-A {
  color: red;
}

.text-B {
  color: blue;
}

.text-C {
  color: green;
}

.text-D {
  color: brown;
}

.v-slide-group>>>.v-slide-group__next {
  width: 20px;
}

.not-friend {
  font-size: 1em;
  font-family: 'Noto Sans JP', sans-serif;
  color: dimgrey;
  text-align: center;
}

@media screen and (min-width: 450px) {
  .rank-icon {
    height: 120px;
    margin: 5px
  }

  .big-text {
    font-size: 1.5em;
  }

  .point-text {
    font-size: 1.5em;
    margin: 0 15px;
  }

  .name-text {
    font-size: 1.5em;
    margin: 10px 0;
  }
}

@media screen and (min-width: 600px) {
  .name-text {
    font-size: 1.5em;
  }

  .rank-icon {
    height: 150px;
    margin: 10px;
  }

  .big-text {
    font-size: 2em;
  }

  .point-text {
    font-size: 2em;
    margin: 0 25px;
  }
}
</style>
