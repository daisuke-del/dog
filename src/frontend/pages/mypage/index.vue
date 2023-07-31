<template>
  <div class="all">
    <h1>{{ nameWithSuffix }}</h1>
    <div class="main-all">
      <v-breadcrumbs
            :items="items"
            divider=">"
      />
      <common-cropperjs
        v-show="modalCropper"
        :image-number="imageNumber"
        @close-image-modal="closeModalCrop"
        @save-crop-image="saveCropImage"
      />
      <user-dialog
        :dialog.sync="userDialog"
        :dog-info="dogInfo"
        @choice-close="choiceClose"
        @add-favorite="addFavorite"
        @delete-favorite="deleteFavorite"
      />
      <div class="main-wrap">
        <v-card light class="dog-card">
          <div class="image-wrap">
            <v-img :src="displayImage" />
            <v-btn class="image-icon"
              fab
              color="primary"
              @click="modalCroppers"
            >
              <v-icon color="white" large> mdi-image-size-select-actual </v-icon>
            </v-btn>
          </div>
        </v-card>
        <v-row class="mt-3 change-image-wrap">
          <v-col cols="4">
            <v-img :src="userWithImage1" @click="changeImage(1)" />
          </v-col>
          <v-col cols="4">
            <v-img v-if="dogImage2" :src="userWithImage2" @click="changeImage(2)" />
            <v-img v-else :src="require('@/../storage/image/dogimages/dog-plus.png')" @click="storeImage(2)" />
          </v-col>
          <v-col cols="4">
            <v-img v-if="dogImage3" :src="userWithImage3" @click="changeImage(3)" />
            <v-img v-else :src="require('@/../storage/image/dogimages/dog-plus.png')" @click="storeImage(3)" />
          </v-col>
        </v-row>
        <p v-if="dogImage3 === 'dog-plus.png'" class="image-text">写真は３枚まで登録可能！</p>
        <div class="mt-4 mb-4">
          <div class="point-wrap d-flex justify-center">
            <p class="point-text">Lv.
              <span v-if="dogPoint > 90" class="text-S">
                {{ dogPoint }}
              </span>
              <span v-else-if="dogPoint > 70" class="text-A">
                {{ dogPoint }}
              </span>
              <span v-else-if="dogPoint > 50" class="text-B">
                {{ dogPoint }}
              </span>
              <span v-else-if="dogPoint > 30" class="text-C">
                {{ dogPoint }}
              </span>
              <span v-else class="text-D">
                {{ dogPoint }}
              </span>
            </p>
          </div>
        </div>
        <div class="info-wrap">
          <p class="info-text" v-if="breed2 === null">犬種：{{ breed1 }}</p>
          <div class="info-text" v-else>
            <p>犬種：ミックス</p>
            <p>・{{ breed1 }}</p>
            <p>・{{ breed2 }}</p>
          </div>
          <p class="info-text">居住地：{{ location }}</p>
          <p class="info-text">生年月日：{{ dogBirthday }}</p>
        </div>
      </div>
      <v-row>
        <v-col cols="12" class="list-all">
          <p v-if="givens.length > 0" class="small-text under-line mt-3 mb-1">
            いいねが来てます！
          </p>
          <v-sheet light class="mx-auto" elevation="2">
            <v-slide-group>
              <v-slide-item v-for="(friend, index) in givens" :key="index">
                <v-card class="mt-3 mb-3 mr-2" height="150" width="130">
                  <v-row>
                    <v-col>
                      <v-img
                        :src="`https://dogiland.jp/storage/${friend['dog_image1']}`"
                        contain
                        rounded
                        @click="showProfile(friend, index)"
                        class="friend-img"
                      />
                      <p class="card-summary-text ml-2">{{ friend['name'] }}</p>
                    </v-col>
                  </v-row>
                </v-card>
              </v-slide-item>
            </v-slide-group>
          </v-sheet>
          <div class="btn-wrap">
            <v-btn
              v-if="isShowFriend && friends.length > 0"
              class="small-text show-friend-btn mt-8"
              light
              @click="isShowFriend = !isShowFriend"
            >
              閉じる
            </v-btn>
            <v-btn
              v-else-if="friends.length > 0"
              class="small-text show-friend-btn mt-8"
              light
              @click="isShowFriend = !isShowFriend"
            >
              フレンド一覧
            </v-btn>
          </div>
        </v-col>
      </v-row>
      <p v-if="friends.length > 0" class="small-text under-line mt-3 mb-5">
            フレンドリスト
          </p>
      <v-row v-show="isShowFriend">
        <v-col
          v-for="(friend, index) in friends"
          :key="index"
          cols="6"
          sm="3"
          lg="2"
          class="d-flex justify-center"
        >
          <v-card light width="200px">
            <v-img
              :src="`https://dogiland.jp/storage/${friend['dog_image1']}`"
              width="200px"
              contain
              rounded
              @click="showProfile(friend, index)"
              class="friend-img"
            />
            <p class="ma-1">{{ friend['name'] }}</p>
            <v-btn
            class="delete-icon"
              elevation="5"
              fab
              height="20px"
              width="20px"
              color="primary"
              @click="deleteFavorite(friend['user_id'])"
            >
              <v-icon small dark> mdi-close-thick </v-icon>
            </v-btn>
          </v-card>
        </v-col>
        <v-col v-if="friends.length === 0" cols="12" class="text-center">
          <p class="not-friend">現在フレンドはいません</p>
          <v-btn
            depressed
            color="primary"
            dark
            class="font-weight-bold"
            @click="findFriend"
          >
            友達を探しに行く
            <v-icon>
              mdi-dog
            </v-icon>
          </v-btn>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
import UserDialog from '@/components/Common/UserDialog';
import CommonCropperjs from '@/components/Common/Cropper'
import user from '@/plugins/modules/user'
import favorite from '@/plugins/modules/favorite'

export default {
  components: {
    UserDialog,
    CommonCropperjs
  },
  name: 'Mypage',
  middleware: 'update_user_status',
  async asyncData({ app }) {
    let userId = null
    let sex = null
    let name = null
    let dogImage1 = 'no-user-image-icon.png'
    let dogImage2
    let dogImage3
    let dogPoint = 0
    let location = null
    let birthday = null
    let breed1 = null
    let breed2 = null
    let voidFlg = 0
    let friends = []
    let givens = []
    await user.getUserInfo().then((response) => {
      app.store.dispatch('authInfo/setAuthInfo', response)
      userId = response['user_id']
      name = response['name']
      dogImage1 = response['dog_image1'] ? response['dog_image1'] : 'no-user-image-icon.png'
      dogImage2 = response['dog_image2'] ? response['dog_image2'] : null
      dogImage3 = response['dog_image3'] ? response['dog_image3'] : null
      dogPoint = response['dog_point']
      location = response['location']
      birthday = response['birthday']
      breed1 = response['breed1']
      breed2 = response['breed2']
      voidFlg = response['dog_image_void_flg'] ? response['dog_image_void_flg'] : 0
      friends = response['friends'],
      givens = response['givens']
    })
    return {
      userId,
      sex,
      name,
      dogImage1,
      dogImage2,
      dogImage3,
      dogPoint,
      location,
      birthday,
      breed1,
      breed2,
      voidFlg,
      friends,
      givens
    }
  },
  data () {
    return {
      userDialog: false,
      index: null,
      modalfile: false,
      message: 'よろしいですか？',
      num: null,
      isShowFriend: true,
      modalCropper: false,
      dogInfo: {
        name: 'バニラ',
        birthday: '2022年1月3日',
        dog_image1: '4.jpg',
        dog_image2: '1.jpg',
        dog_image3: '3.jpg',
        comment: 'バニラ',
        twitter_id: '',
        instagram_id: '',
        tiktok_id: '',
        blog_id: ''
      },
      userId: null,
      name: '',
      dogImage1: 'no-user-image-icon.png',
      dogImage2: null,
      dogImage3: null,
      dogPoint: 0,
      voidFlg: 0,
      items: [
        {
          text: 'トップ',
          disabled: false,
          href: '/'
        },
        {
          text: 'マイページ',
          disabled: false,
          href: '/mypage'
        }
      ],
      displayImage: null,
      imageNumber: 1,
      storeImageNum: null
    }
  },
  mounted () {
    this.displayImage = this.userWithImage1;
  },
  computed: {
    userWithImage1 () {
      return this.dogImage1 && `https://dogiland.jp/storage/${this.dogImage1}`
    },
    userWithImage2 () {
      return this.dogImage2 && `https://dogiland.jp/storage/${this.dogImage2}`
    },
    userWithImage3 () {
      return this.dogImage3 && `https://dogiland.jp/storage/${this.dogImage3}`
    },
    dogBirthday () {
      const birthDate = new Date(this.birthday);
      const year = birthDate.getFullYear();
      const month = ("0" + (birthDate.getMonth() + 1)).slice(-2);
      const day = ("0" + birthDate.getDate()).slice(-2);
      return `${year}年${month}月${day}日`;
    },
    nameWithSuffix() {
      if (this.gender === 'male') {
        return this.name + "くん";
      } else {
        return this.name + "ちゃん";
      }
    },
  },
  methods: {
    modalCroppers() {
      this.modalCropper = true
    },
    showProfile(userInfo, index) {
      this.dogInfo = userInfo
      this.index = index
      this.userDialog = true
      console.log(this.dogInfo)
    },
    summaryMethod(status) {
      this.modal = status
    },
    closeModalCrop() {
      this.modalCropper = false
    },
    saveCropImage(dogImage) {
      this.modalCropper = false
      if (this.storeImageNum) {
        user.updateDogImage(dogImage, this.storeImageNum).then((response) => {
          this.$store.dispatch('authInfo/setAuthInfo', response)
          window.location.reload()
        }).catch(() => {
          this.$store.dispatch('snackbar/setMessage', '画像の更新に失敗しました。')
          this.$store.dispatch('snackbar/snackOn')
        }).finally(() => {
          this.storeImageNum = null
        })
      } else {
        user.updateDogImage(dogImage, this.imageNumber).then((response) => {
          this.$store.dispatch('authInfo/setAuthInfo', response)
          window.location.reload()
        }).catch(() => {
          this.$store.dispatch('snackbar/setMessage', '画像の更新に失敗しました。')
          this.$store.dispatch('snackbar/snackOn')
        })
      }
    },
    clickNotFavorite(toUserId, userName, index) {
      if (confirm(userName + 'のお気に入りを解除してもいいですか？')) {
        favorite.deleteFavorite(toUserId, this.$store.getters['authInfo/userId']).then(() => {
          this.friends.splice(index, 1)
        })
      }
    },
    scoreClick() {
      this.scoreDialog = true
    },
    changeImage (num) {
      if (num === 1) {
        this.imageNumber = 1
        this.displayImage = this.userWithImage1
      } else if (num === 2) {
        this.imageNumber = 2
        this.displayImage = this.userWithImage2
      } else if (num === 3) {
        this.imageNumber = 3
        this.displayImage = this.userWithImage3
      }
    },
    storeImage (num) {
      this.storeImageNum = num
      this.modalCropper = true
    },
    choiceClose () {
      this.userDialog = false
    },
    addFavorite(friendId) {
      if (!this.$auth.loggedIn) {
        this.$router.push('/login')
      } else {
        favorite.addFavoriteFromMypage(friendId).then((response) => {
          this.dogInfo = response['dog_info']
          this.givens = response['givens']
          this.friends = response['friends']
        })
      }
    },
    deleteFavorite(friendId) {
      if (!this.$auth.loggedIn) {
        this.$router.push('/login')
      } else {
        favorite.deleteFavoriteFromMypage(friendId).then((response) => {
          this.dogInfo = response['dog_info']
          this.givens = response['givens']
          this.friends = response['friends']
        })
      }
    },
    findFriend () {
      this.$router.push('/dog')
    }
  }
}
</script>

<style scoped>
h1 {
    font-family: 'Rampart One', cursive;
    color: dimgrey;
    text-align: center;
}
.all {
  padding: 10px 10px 30px 10px;
  min-width: 350px;
  max-width: 500px;
  align-items: center;
  margin: 0 auto;
}

.name-text {
  font-size: 1.5em;
  font-family: 'Noto Sans JP', sans-serif;
  color: dimgrey;
  font-weight: bolder;
  text-align: center;
  background-color: rgba(128, 128, 128, 0.1);
  padding: 5px;
  border-radius: 5px;
  backdrop-filter: blur(5px);
}

.info-wrap {
  background-color: rgba(128, 128, 128, 0.1);
  padding: 5px;
  border-radius: 5px;
  backdrop-filter: blur(5px);
}

.info-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: dimgrey;
  font-weight: bolder;
  max-width: 300px;
  margin: 0 auto;
}

.dog-card {
  max-width: 400px;
  margin: 0 auto;
}

.image-wrap {
  position: relative;
}

.change-image-wrap {
  max-width: 400px;
  margin: 0 auto;
}

.image-icon {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  bottom: -2%;
  right: -2%;
  z-index: 2;
}

.delete-icon {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  bottom: -5%;
  right: -5%;
}

.small-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: dimgrey;
  font-weight: bolder;
}

.under-line {
  text-decoration: underline;
  text-decoration-thickness: 0.5em;
  text-decoration-color: rgba(255, 228, 0, 0.4);
  text-underline-offset: -0.2em;
  text-decoration-skip-ink: none;
}

.point-text {
  font-family: 'Rampart One', cursive;
  font-size: 2.5em;
  color: dimgrey;
  text-align: center;
  margin-bottom: 0;
}

.point-wrap {
  text-align: center;
  cursor: pointer;
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
}

.friend-img {
  cursor: pointer;
}

.image-text {
  font-size: 0.8em;
  font-family: 'Noto Sans JP', sans-serif;
  color: dimgrey;
  text-align: center;
}
</style>
