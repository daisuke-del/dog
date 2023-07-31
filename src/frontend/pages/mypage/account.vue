<template>
  <div class="all">
    <v-row class="mt-3 mb-0" justify="center" align="center">
      <v-col cols="12" sm="8" xl="5" class="pa-0">
        <h1 class="my-0 mx-3 mx-sm-0">
          登録情報
        </h1>
        <v-breadcrumbs
            :items="items"
            divider=">"
        />
        <div>
          <edit-email
            ref="editEmail"
            class="my-5 mx-2 mx-sm-0"
            :input-email.sync="email"
            :position="stepperPosition"
            :email-rules="emailRules"
            :email-loading="emailLoading"
            :password-rules="passwordRules"
            @clickUpdateEmail="clickUpdateEmail"
            @okClick="editEmail"
            @backClick="backClick"
          />
          <edit-name
            ref="editName"
            class="my-5 mx-2 mx-sm-0"
            :input-name.sync="name"
            :name-rules="nameRules"
            :loading="nameSendLoading"
            :show-tooltip="showNameTooltip"
            @editName="editName"
          />
          <edit-profile
            ref="editProfile"
            class="my-5 mx-2 mx-sm-0"
            :breed1="breed1"
            :breed2="breed2"
            :weight="weight"
            :birthday="birthday"
            :locaton="location"
            :breed-rules="breedRules"
            :weight-rules="weightRules"
            :birthday-rules="birthdayRules"
            :loation-rules="locationRules"
            :breed-loading="breedLoading"
            :weight-loading="weightLoading"
            :birthday-loading="birthdayLoading"
            :location-loading="locationLoading"
            :show-breed-tooltip="showBreedTooltip"
            :show-weight-tooltip="showWeightTooltip"
            :show-birthday-tooltip="showBirthdayTooltip"
            :show-location-tooltip="showLocationTooltip"
            @editBreed="editBreed"
            @editWeight="editWeight"
            @editBirthday="editBirthday"
            @editLocation="editLocation"
          />
          <edit-sns
            ref="editSns"
            class="my-5 mx-2 mx-sm-0"
            :input-instagram.sync="instagramId"
            :input-twitter.sync="twitterId"
            :input-tiktok.sync="tiktokId"
            :input-blog.sync="blogId"
            :instagram-rules="instagramRules"
            :twitter-rules="twitterRules"
            :tiktok-rules="tiktokRules"
            :blog-rules="blogRules"
            :instagram-loading="instagramLoading"
            :twitter-loading="twitterLoading"
            :tiktok-loading="tiktokLoading"
            :blog-loading="blogLoading"
            :show-instagram-tooltip="showInstagramTooltip"
            :show-twitter-tooltip="showTwitterTooltip"
            :show-tiktok-tooltip="showTiktokTooltip"
            :show-blog-tooltip="showBlogTooltip"
            @editInstagram="editInstagram"
            @editTwitter="editTwitter"
            @editTiktok="editTiktok"
            @editBlog="editBlog"
          />
          <div class="leave-area mx-2 mx-sm-0">
            <a class="leave-button" @click="leaveClick">
              退会する
            </a>
          </div>
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import EditEmail from '@/components/Mypage/EditEmail'
import EditName from '@/components/Mypage/EditName'
import EditProfile from '@/components/Mypage/EditProfile'
import EditSns from '@/components/Mypage/EditSns'
import constants from '@/utils/constants'
import user from '~/plugins/modules/user'

export default {
  components: {
    EditEmail,
    EditName,
    EditProfile,
    EditSns
  },
  name: 'Mypageaccount',
  middleware: 'update_user_status',
  async asyncData({ app }) {
    let userId = null
    let sex = null
    let email = null
    let name = null
    let weight = null
    let location = null
    let birthday = null
    let breed1 = null
    let breed2 = null
    let voidFlg = 0
    let friends = []
    let instagramId = ''
    let twitterId = ''
    let tiktokId = ''
    let blogId = ''
    await user.getUserInfo().then((response) => {
      app.store.dispatch('authInfo/setAuthInfo', response)
      userId = response['user_id']
      sex = response['sex']
      email = response['email']
      name = response['name']
      weight = response['weight']
      location = response['location']
      birthday = response['birthday']
      breed1 = response['breed1']
      breed2 = response['breed2']
      voidFlg = response['dog_image_void_flg'] ? response['dog_image_void_flg'] : 0
      friends = response['friends']
      instagramId = response['instagram_id'] ? response['instagram_id'] : ''
      twitterId = response['twitter_id'] ? response['twitter_id'] : ''
      tiktokId = response['tiktok_id'] ? response['tiktok_id'] : ''
      blogId = response['blog_id'] ? response['blog_id'] : ''
    })
    return {
      userId,
      sex,
      email,
      name,
      weight,
      location,
      birthday,
      breed1,
      breed2,
      voidFlg,
      friends,
      instagramId,
      twitterId,
      tiktokId,
      blogId
    }
  },
  data () {
    return {
      userId: null,
      year: null,
      month: null,
      day: null,
      instagramId: '',
      twitterId: '',
      tiktokId: '',
      friends: [],
      items: [
        {
          text: 'トップ',
          disabled: false,
          href: '/'
        },
        {
          text: '登録情報',
          disabled: false,
          href: '/mypage'
        }
      ],
      displayImage: null,
      imageNumber: 1,
      storeImageNum: null,
      stepperPosition: 1,
      loading: false,
      emailLoading: false,
      nameLoading: false,
      breedLoading: false,
      weightLoading: false,
      birthdayLoading: false,
      locationLoading: false,
      instagramLoading: false,
      twitterLoading: false,
      tiktokLoading: false,
      blogLoading: false,
      emailRules: [
        value => !!value || 'メールアドレスが入力されていません。',
        value => value.match(constants.mailValidation) != null || 'メールアドレスの形式ではありません。'
      ],
      passwordRules: [
        value => !!value || 'パスワードが入力されていません。',
        value => (value || '').length >= constants.minPasswordLength || '6文字以上で入力してください',
        value => (value || '').length <= constants.maxPasswordLength || '32文字以内で入力してください'
      ],
      nameRules: [
        value => !!value || 'ニックネームが入力されていません。',
        value => (value || '').length <= constants.maxNameLength || '10文字以内で入力してください',
      ],
      breedRules: [
        value => !!value || '犬種が入力されていません。'
      ],
      weightRules: [
        value => !!value || '体重が入力されていません。',
        value => (value || '').length <= constants.maxWeightLength || '2桁以上入力できません',
        value => value.match(constants.numberValidation) != null || '半角英数字で入力してください'
      ],
      birthdayRules: [
        value => !!value || '生年月日が入力されていません。'
      ],
      locationRules: [
        value => !!value || '居住場所が選択されていません。'
      ],
      instagramRules: [
        value => !!value || 'instagramのIDが入力されていません。'
      ],
      twitterRules: [
        value => !!value || 'twitterのIDが入力されていません。'
      ],
      tiktokRules: [
        value => !!value || 'tiktokのIDが入力されていません。'
      ],
      blogRules: [
        value => !!value || 'ブログのURLが入力されていません。'
      ],
      newEmail: '',
      showPasswordTooltip: false,
      showNameTooltip: false,
      showBreedTooltip: false,
      showWeightTooltip: false,
      showBirthdayTooltip: false,
      showLocationTooltip: false,
      showInstagramTooltip: false,
      showTwitterTooltip: false,
      showTiktokTooltip: false,
      showBlogTooltip: false,
      passwordSendLoading: false,
      passwordMessage: '',
      nameSendLoading: false,
    }
  },
  methods: {
    backClick () {
      this.stepperPosition = 1
    },
    async clickUpdateEmail(mail) {
      await user.checkEmail(mail).then(() => {
        this.stepperPosition = 2
        this.newEmail = mail
      }).catch(() => {
      })
    },
    async editEmail (password) {
      await user.updateEmail(this.newEmail, password).then(() => {
        this.stepperPosition = 3
        this.$store.dispatch('authInfo/setEmail', this.newEmail)
        setTimeout(this.backClick, 3000)
      }).catch(() => {
        this.stepperPosition = 1
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
    },
    async editName (name) {
      this.nameSendLoading = true
      await user.updateName(name).then(() => {
        this.showNameTooltip = true
        this.$store.dispatch('authInfo/setName', name)
        setTimeout(() => {
          this.showNameTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.nameSendLoading = false
    },
    async editBreed (breed1, breed2 = '') {
      this.breedLoading = true
      await user.updateBreed(breed1, breed2).then(() => {
        this.showBreedTooltip = true
        this.$store.dispatch('authInfo/setBreed1', breed1)
        if (breed2 !== '') {
          this.$store.dispatch('authInfo/setBreed2', breed2)
        }
        this.breed1 = breed1
        this.breed2 = breed2
        setTimeout(() => {
          this.showBreedTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.breedLoading = false
    },
    async editWeight (weight) {
      this.weightLoading = true
      const weightInt = Number(weight)
      await user.updateWeight(weightInt).then(() => {
        this.showWeightTooltip = true
        this.$store.dispatch('authInfo/setWeight', weightInt)
        this.weight = weightInt
        setTimeout(() => {
          this.showWeightTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.weightLoading = false
    },
    async editBirthday (year, month, day) {
      this.birthdayLoading = true
      await user.updateBirthday(year, month, day).then((response) => {
        this.showBirthdayTooltip = true
        this.$store.dispatch('authInfo/setBirthday', response.birthday)
        this.birthday = response.birthday
        setTimeout(() => {
          this.showBirthdayTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.birthdayLoading = false
    },
    async editLocation (location) {
      this.locationLoading = true
      await user.updateLocation(location).then(() => {
        this.showLocationTooltip = true
        this.$store.dispatch('authInfo/setLocation', location)
        this.location = location
        setTimeout(() => {
          this.showLocationTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.salaryLoading = false
    },
    async editInstagram (instagram) {
      this.instagramLoading = true
      await user.updateInstagram(instagram).then(() => {
        this.showInstagramTooltip = true
        this.$store.dispatch('authInfo/setInstagramId', instagram)
        setTimeout(() => {
          this.showInstagramTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.instagramLoading = false
    },
    async editTwitter (twitter) {
      this.twitterLoading = true
      await user.updateTwitter(twitter).then(() => {
        this.showTwitterTooltip = true
        this.$store.dispatch('authInfo/setTwitterId', twitter)
        setTimeout(() => {
          this.showTwitterTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.twitterLoading = false
    },
    async editTiktok (tiktok) {
      this.tiktokLoading = true
      await user.updateTiktok(tiktok).then(() => {
        this.showTiktokTooltip = true
        this.$store.dispatch('authInfo/setTiktokId', tiktok)
        setTimeout(() => {
          this.showTiktokTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.tiktokLoading = false
    },
    async editBlog (blog) {
      this.blogLoading = true
      await user.updateBlog(blog).then(() => {
        this.showBlogTooltip = true
        this.$store.dispatch('authInfo/setBlogId', tiktok)
        setTimeout(() => {
          this.showBlogTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.blogLoading = false
    },
    leaveClick() {
      if (confirm('本当に退会して良いですか？')) {
        user.leave().then(() => {
          this.$auth.logout()
          this.$router.push('/')
        }).catch(() => {
          this.$store.dispatch('snackbar/setMessage', '退会できませんでした')
          this.$store.dispatch('snackbar/snackOn')
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
  margin: 20px;
  text-align: center;
}

.leave-area {
  text-align: right;
}

.leave-button {
  color: #000;
  text-decoration: underline;
  padding-right: 10px;
}
</style>