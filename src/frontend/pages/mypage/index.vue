<template>
  <div>
    <h1>{{ title }}</h1>
    <div class="main-all">
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
            <v-card light class="my-card ml-auto">
              <div class="rank-wrap">
                <p class="big-text">総合ランク</p>
                <v-img v-if="rank > 80 && score === 'A'" :src="require('~/assets/image/rank/gold.png')"
                  class="rank-icon" contain />
                <v-img v-else-if="rank > 50 && score === 'B'" :src="require('~/assets/image/rank/silver.png')"
                  class="rank-icon" contain />
                <v-img v-else-if="score !== 'C'" :src="require('~/assets/image/rank/blond.png')" class="rank-icon"
                  contain />
                <v-img v-else :src="require('~/assets/image/rank/nomal.png')" class="rank-icon" contain />
              </div>
              <div class="point-wrap">
                <p class="point-text">美女レベル：{{ rank }}</p>
                <p class="point-text">継続スコア：{{ score }}</p>
              </div>
            </v-card>
          </v-col>
        </v-row>
      </div>
      <v-row>
        <v-col cols="12" class="list-all">
          <p class="name-text">フレンドリスト</p>
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
            <v-btn class="small-text show-friend-btn mt-8" text light @click="isShowFriend = !isShowFriend">
              全てのフレンド
            </v-btn>
          </div>
        </v-col>
      </v-row>
      <v-row v-show="isShowFriend">
        <v-col v-for="n in 15" :key="n" cols="6" md="3" lg="2" class="d-flex justify-center">
          <v-card light @click="showProfile(n)" height="250px" width="200px">
            <v-img :src="require('@/../storage/image/faceimages/' + n + '.jpeg')" height="150px" contain rounded />
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
  // async asyncData() {
  //   return user.getUserInfo().then((response) => {
  //     return {
  //       name: response['name'],
  //       faceStatus: response['status'],
  //       faceImage: response['face_image'],
  //       rank: response['face_point'],
  //       score: response['score'],
  //       friends: response['friends']
  //     }
  //   })
  // },
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
      name: 'test',
      rank: 100,
      faceImage: '99.jpeg',
      score: 'A'
    }
  },
  props: {
    msg: String,
  },
  methods: {
    modalCroppers () {
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
  color: slategray;
  margin-top: 16px;
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
}

.big-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
  text-align: center;
  margin-bottom: 0;
}

.small-text {
  font-size: 0.75em;
  font-weight: bolder;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.rank-icon {
  height: 100px;
}

.point-text {
  font-size: 0.9em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
  margin-bottom: 0;
  text-align: center;
}

.point-wrap {
  padding-top: 10px;
}

.card-summary-text {
  font-size: 0.75em;
  font-weight: bolder;
  font-family: 'Noto Sans JP', sans-serif;
  padding-bottom: 0;
  margin-bottom: 0;
  color: slategray;
}

.btn-wrap {
  text-align: center;
}

.sns-icon {
  margin-right: 5px;
}

.show-friend-btn {
  font-weight: bolder;
  font-size: large;
}

@media screen and (min-width: 450px) {
  .point-text {
    font-size: 1.2em;
    margin-top: 10px;
  }
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 1.5em;
  }

  .rank-wrap {
    padding-top: 10px;
  }

  .rank-icon {
    margin-top: 20px;
  }
}

@media screen and (min-width: 1000px) {
  .point-text {
    font-size: 1.5em;
    margin-top: 10px;
  }

  .point-wrap {
    padding-top: 30px;
  }
}
</style>
