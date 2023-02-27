<template>
  <div class="content mx-auto">
    <h1 v-if="position === 3">自分の顔を評価</h1>
    <h1 v-else-if="position === 2">顔写真をアップロード</h1>
    <h1 v-else>無料会員登録</h1>
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
        顔写真
      </v-stepper-step>
      <v-divider />
      <v-stepper-step
        :complete="position > 3"
        step="3"
      >
        評価
      </v-stepper-step>
      <v-divider />
      <v-stepper-step
        step="4"
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
            @store-user-info="signupSliderImage"
          />
        </div>
      </v-stepper-content>
      <v-stepper-content step="2">
        <div class="mx-auto">
          <register-face
            @store-face-image="storeFaceImage"
            @click-back="transitionContent"
          />
        </div>
      </v-stepper-content>
      <v-stepper-content step="3">
        <div class="mx-auto">
          <evaluate-face
            :sliderFaces="sliderFaces"
            @store-face-point="storeFacePoint"
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
import RegisterFace from '~/components/Signup/RegisterFace'
import EvaluateFace from '~/components/Signup/EvaluateFace'
import SignupCompletion from '~/components/Signup/SignupCompletion'
import constants from '~/utils/constants'
import user from '~/plugins/modules/user'
import slider from '~/plugins/modules/slider'
export default {
  name: 'PagesSignup',
  auth: false,
  components: {
    SignupForm,
    RegisterFace,
    EvaluateFace,
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
      postUserInfoLoading: false,
      showErrorMessage: false,
      errorMessage: '',
      previousPage: null,
      sendButtonShow: false,
      gender: null,
      name: null,
      email: null,
      password: null,
      height: null,
      weight: null,
      age: null,
      salary: null,
      facebookId: null,
      instagramId: null,
      twitterId: null,
      facePoint: null,
      faceImage: null,
      sliderFaces: [
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0},
        { face_image: '0.jpeg', face_point: 0}
      ],
      genderSort: null
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
    async signupSliderImage (userInfo) {
      this.postUserInfoLoading = true
      this.gender = userInfo.gender
      this.name = userInfo.name
      this.email = userInfo.email
      this.password = userInfo.password
      this.height = userInfo.height
      this.weight = userInfo.weight
      this.age = userInfo.age
      this.salary = userInfo.salary
      this.facebookId = userInfo.facebookId
      this.instagramId = userInfo.instagramId
      this.twitterId = userInfo.twitterId
      await slider.signupSliderImage(this.gender, this.email).then((response) => {
        this.sliderFaces.splice(0, response.length)
        this.sliderFaces.push(...response)
        this.position = 2
      }).catch(() => {
        this.position = 1
      })
      this.postUserInfoLoading = false
    },
    storeFaceImage (faceImage) {
      this.faceImage = faceImage
      if (this.faceImage === null) {
        this.$store.dispatch('snackbar/setMessage', 'もう一度やり直してください。')
        this.$store.dispatch('snackbar/snackOn')
      } else {
        this.position = 3
      }
    },
    async storeFacePoint (sliderValue) {
      this.facePoint = this.sliderFaces[sliderValue].face_point
      await this.$axios.get('/sanctum/csrf-cookie', { withCredentials: true })
      await user.signup(
        this.gender,
        this.name,
        this.email,
        this.password,
        this.height,
        this.weight,
        this.age,
        this.salary,
        this.facebookId,
        this.instagramId,
        this.twitterId,
        this.facePoint,
        this.faceImage
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
