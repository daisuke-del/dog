<template>
  <div class="content mx-auto">
    <h1 v-if="position > 3">認証コードを入力</h1>
    <h1 v-else-if="position > 2">自分の顔を評価</h1>
    <h1 v-else-if="position > 1">顔写真をアップロード</h1>
    <h1 v-else>新規会員登録（無料）</h1>
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
        登録情報
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
        :complete="position > 4"
        step="4"
      >
        認証コード
      </v-stepper-step>
      <v-divider />
      <v-stepper-step
        step="5"
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
          <register-face
            @store-face-image="storeFaceImage"
            @click-back="transitionContent"
          />
        </div>
      </v-stepper-content>
      <v-stepper-content step="3">
        <div class="mx-auto">
          <evaluate-face
            @store-face-point="storeFacePoint"
            @click-back="transitionContent"
          />
        </div>
      </v-stepper-content>
      <v-stepper-content step="4">
        <auth-code
          ref="authCode"
          :error-show="authErrorShow"
          :send-loading="authSendLoading"
          :send-button-show="sendButtonShow"
          @input="inputAuthCode"
          @click-back="transitionContent"
        />
      </v-stepper-content>
      <v-stepper-content step="5">
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
import AuthCode from '~/components/Signup/AuthCode'
import SignupCompletion from '~/components/Signup/SignupCompletion'
import constants from '~/utils/constants'
// import user from '~/plugins/modules/user'
export default {
  name: 'PagesSignup',
  auth: false,
  components: {
    SignupForm,
    RegisterFace,
    EvaluateFace,
    AuthCode,
    SignupCompletion
  },
  asyncData ({ app, $auth, redirect }) {
    if ($auth.loggedIn) {
      if (app.store.state.redirect.pageUrl) {
        redirect(app.store.redirect.pageUrl)
        app.store.dispatch('redirect/deletePageUrl')
      } else {
        app.router.replace('/mypage')
      }
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
      authSendLoading: false,
      showErrorMessage: false,
      errorMessage: '',
      previousPage: null,
      sendButtonShow: false,
      breadcrumbs: [
        {
          name: 'TOP',
          item: '/'
        },
        {
          name: 'Signup',
          item: this.$route.fullPath
        }
      ]
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
    storeUserInfo (userInfo) {
      this.position = 2
      this.postUserInfoLoading = true
      if (!this.validationMail(userInfo.mail)) {
        this.postUserInfoLoading = false
        return
      }
      if (!this.validationPass(userInfo.password)) {
        this.postUserInfoLoading = false
        return
      }
      this.$store.dispatch('signup/setSignup', {
        gender: userInfo.gender,
        name: userInfo.name,
        mail: userInfo.mail,
        password: userInfo.password,
        height: userInfo.height,
        weight: userInfo.weight,
        age: userInfo.age,
        salary: userInfo.salary
      })
      this.postUserInfoLoading = false
    },
    storeFaceImage (faceImage) {
      console.log(faceImage)
      this.$store.dispatch('signup/setFaceImage', {
        faceImage
      }) 
      this.position = 3
    },
    storeFacePoint (facePoint) {
      this.$store.dispatch('signup/setFacePoint', {
        facePoint
      }) 
      this.position = 4
    },
    inputAuthCode (authCode) {
      if (authCode.length === 6) {
        this.position = 5
      }
    },
    // async inputAuthCode (authCode) {
    //   if (authCode.length === 6) {
    //     this.authSendLoading = true
    //     this.authErrorShow = false
    //     this.sendButtonShow = false

    //     await user.auth(authCode).then(async () => {
    //       this.position = 5
    //       await this.$auth.setUserToken('200')
    //       setTimeout(this.redirect, 2000)
    //     }).catch((error) => {
    //       if (error === 400) {
    //         this.$ref.authCode.onErrorAuthCode()
    //       } else {
    //         this.sendButtonShow = true
    //       }
    //     })
    //     this.authSendLoading = false
    //   }
    // },
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
  max-width: 600px;
  min-width: 350px;
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