<template>
  <div>
    <div class="main-all">
      <h1>{{ title }}</h1>
      <common-cropperjs v-show="modalCropper" @close-image-modal="closeModalCrop" @save-crop-image="saveCropImage" />
      <common-modal :n="num" v-show="modal" @summary-method="summaryMethod" />
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
                  <v-img v-if="rank > 80 && score === 'A'" :src="require('~/assets/image/rank/gold.png')"
                    class="rank-icon" contain />
                  <v-img v-else-if="rank > 50 && score === 'B'" :src="require('~/assets/image/rank/silver.png')"
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
          <v-sheet light class="mx-auto" elevation="8">
            <v-slide-group v-model="model" active-class="success" show-arrows>
              <v-slide-item v-for="n in 15" :key="n">
                <v-card @click="showProfile(n)" class="mt-3 mb-3 mr-2" height="150" width="100">
                  <v-row>
                    <v-col>
                      <v-img :src="require('@/../storage/image/faceimages/' + n + '.jpeg')" max-height="100" contain
                        rounded />
                      <p class="card-summary-text mt-2 ml-2">田中タロウ</p>
                      <v-btn class="delete-icon" elevation="5" fab height="20px" width="20px" color="primary">
                        <v-icon small dark> mdi-close-thick </v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-card>
              </v-slide-item>
            </v-slide-group>
          </v-sheet>
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
        <v-col v-for="n in 15" :key="n" cols="6" md="3" lg="2" class="d-flex justify-center">
          <v-card light @click="showProfile(n)" height="250px" width="200px">
            <v-img :src="require('@/../storage/image/faceimages/' + n + '.jpeg')" width="200px" contain rounded />
            <p class="card-summary-text">田中タロウ</p>
            <div class="icon-wrap">
              <v-btn icon class="sns-icon">
                <v-icon> mdi-twitter </v-icon>
              </v-btn>
              <v-btn icon class="sns-icon">
                <v-icon> mdi-instagram </v-icon>
              </v-btn>
              <v-btn icon class="sns-icon">
                <v-icon> mdi-facebook </v-icon>
              </v-btn>
            </div>
            <v-btn class="delete-icon" elevation="5" fab height="20px" width="20px" color="primary">
              <v-icon small dark> mdi-close-thick </v-icon>
            </v-btn>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
import CommonModal from '@/components/Common/Modal'
import CommonCropperjs from '@/components/Common/Cropper'
import user from '@/plugins/modules/user'
export default {
  components: {
    CommonModal,
    CommonCropperjs
  },
  name: 'MyPage',
  asyncData({ app }) {
    return user.getUserInfo().then((response) => {
      app.store.dispatch('authInfo/setAuthInfo', response)
      return {
        gender: response['gender'],
        name: response['name'] ? response['name'] : '名無しさん',
        rank: response['rank'] ? response['rank'] : 'N',
        faceImage: response['face_image'] ? response['face_image'] : 'no-user-image-icon.jpeg',
        facePoint: response['face_point'] ? response['face_point'] : 0,
        score: response['score'] ? response['score'] : 0,
        voidFlg: response['face_image_void_flg'] ? response['face_image_void_flg'] : 0,
        friends: response['friends'] ? response['friends'] : ''
      }
    })
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
    }
  },
  props: {
    msg: String,
  },
  methods: {
    modalCroppers() {
      this.modalCropper = true
    },
    showProfile(num) {
      this.num = num
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
    }
  },
}
</script>

<style scoped>
h1 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  margin: 20px;
  text-align: center;
}

.main-all {
  align-items: center;
  margin: 10px;
  min-width: 350px;
}

.main-wrap {
  max-width: 650px;
  margin: 0 auto;
}

.list-all {
  align-items: center;
  max-width: 650px;
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
