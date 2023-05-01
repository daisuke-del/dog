<template>
  <div class="content mx-auto">
    <h1 v-if="position === 2">写真をアップロード</h1>
    <h1 v-else>愛犬を登録</h1>
    <v-stepper
      v-model="position"
      class="register-wrap"
      alt-labels
      light
    >
      <v-stepper-header>
      <v-stepper-step
        :complete="position > 1"
        step="1"
      >
        登録
      </v-stepper-step>
      <v-divider />
      <v-stepper-step
        :complete="position > 2"
        step="2"
      >
        写真
      </v-stepper-step>
      <v-divider />
      <v-stepper-step
        step="3"
      >
        完了
      </v-stepper-step>
    </v-stepper-header>

    <v-stepper-items>
      <v-stepper-content step="1">
        <div class="mx-auto">
          <signup-form
            :validation="validation"
            :min-pass-length="minPassLength"
            :max-pass-length="maxPassLength"
            :send-loading="postUserInfoLoading"
            @store-user-info="storeUserInfo"
          />
        </div>
      </v-stepper-content>
      <v-stepper-content step="2">
        <div class="mx-auto">
          <register-image
            @store-face-image="storeDogImage"
            @click-back="transitionContent"
          />
        </div>
      </v-stepper-content>
      <v-stepper-content step="4">
        <signup-completion
          @mypage="mypageClick"
        />
      </v-stepper-content>
    </v-stepper-items>
    </v-stepper>
  </div>
</template>
<script>
import SignupForm from '~/components/Signup/SignupForm'
import RegisterImage from '~/components/Signup/RegisterImage'
import SignupCompletion from '~/components/Signup/SignupCompletion'
import constants from '~/utils/constants'
import user from '~/plugins/modules/user'
export default {
  name: 'PagesSignup',
  auth: false,
  components: {
    SignupForm,
    RegisterImage,
    SignupCompletion
  },
  asyncData ({ app, $auth }) {
    if ($auth.loggedIn) {
      app.router.replace('/mypage')
    }
  },
  beforeRouteEnter (to, from, next) {
    next((vm) => {
      vm.previousPage = from.path
    })
  },
  data () {
    return {
      position: 1,
      authErrorShow: false,
      validation: constants.mailValidation,
      minPassLength: constants.minPassLength,
      maxPassLength: constants.maxNameLength,
      showErrorMessage: false,
      errorMessage: '',
      previousPage: null,
      sendButtonShow: false,
      sex: null,
      name: null,
      email: null,
      password: null,
      weight: null,
      age: null,
      breed: null,
      instagramId: null,
      twitterId: null,
      tiktokId: null,
      blogId: null,
      dogPoint: null,
      dogImage: null,
      dogImage2: null,
      dogImage3: null,
    }
  },
  mounted () {
    if (!constants.notSavePreviousPage.includes(this.previousPage)) {
      this.$store.dispatch('redirect/addPageUrl', this.previousPage)
    }
  },
  methods: {
    clickForm () {
      this.transitionContent(2)
    },
    async storeUserInfo (userInfo) {
      this.sex = userInfo.sex
      this.name = userInfo.name
      this.email = userInfo.email
      this.password = userInfo.password
      this.weight = userInfo.weight
      this.age = userInfo.age
      this.breed = userInfo.breed
      this.breed2 = userInfo.breed2 ? userInfo.breed2 : null
      this.instagramId = userInfo.instagramId
      this.twitterId = userInfo.twitterId
      this.tiktokId = userInfo.tiktokId,
      this.blogId = userInfo.blogId
      this.position = 2
    },
    storeDogImage (dogImage, dogImage2, dogImage3) {
      this.dogImage = dogImage
      this.dogImage2 = dogImage2 ? dogImage2 : null
      this.dogImage3 = dogImage3 ? dogImage3 : null
      if (this.dogImage === null) {
        this.$store.dispatch('snackbar/setMessage', 'もう一度やり直してください。')
        this.$store.dispatch('snackbar/snackOn')
      } else {
        this.position = 3
      }
    },
    async storeDogPoint (sliderValue) {
      this.dogPoint = this.sliderFaces[sliderValue].dog_point
      await this.$axios.get('/sanctum/csrf-cookie', { withCredentials: true })
      await user.signup(
        this.sex,
        this.name,
        this.email,
        this.password,
        this.weight,
        this.birthday,
        this.breed,
        this.instagramId,
        this.twitterId,
        this.tiktokId,
        this.blogId,
        this.dogImage
      ).then((response) => {
        this.position = 4
        this.$auth.setUserToken('200')
        this.$store.dispatch('authInfo/setAuthInfo', response.data)
        setTimeout(this.$router.push('/mypage'), 2000)
      })
    },
    redirect () {
      const redirectUrl = this.$store.state.redirect.pageUrl
      if (redirectUrl) {
        this.$router.replace(redirectUrl)
      } else {
        this.$route.replace("/")
      }
      this.$store.dispatch('redirect/deletePageUrl')
    },
    mypageClick () {
      this.$router.push('/mypage')
    },
    validationMail (mail) {
      return mail.match(this.validation) != null
    },
    validationPass (pass) {
      return pass.length >= this.minPassLength && pass.length <= this.maxPassLength
    },
    transitionContent (num) {
      this.position = num
    }
  }
}
</script>

<style scoped>
.content {
  max-width: 480px;
  min-width: 300px;
}

.register-wrap {
  margin-bottom: 50px;
}

h1 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  margin: 20px;
  text-align: center;
}

@media only screen and (max-width: 959px) {
  .v-stepper >>> .v-stepper__label {
    display: flex !important;
  }
}
</style>
