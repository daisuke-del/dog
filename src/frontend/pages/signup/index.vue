<template>
  <div class="content mx-auto">
    <h1 v-if="position ===2 && isChoice">可愛い方を選ぼう</h1>
    <h1 v-else-if="position === 2">写真をアップロード</h1>
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
            @store-user-info="storeUserInfo"
          />
        </div>
      </v-stepper-content>
      <v-stepper-content step="2">
        <div class="mx-auto">
          <diagnosis-choice
            v-if="choiceCount < 3 && isChoice"
            :leftDog="choiceDogs[0]"
            :rightDog="choiceDogs[1]"
            @choice-left="choiceLeft"
            @choice-right="choiceRight"
            @alert-left="clickAlertLeft"
            @alert-right="clickAlertRight"
          />
          <register-image
          v-else
            @store-face-image="storeDogImage"
            @click-back="transitionContent"
          />
        </div>
      </v-stepper-content>
      <v-stepper-content step="3">
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
      breed1: null,
      breed2: null,
      instagramId: null,
      twitterId: null,
      tiktokId: null,
      blogId: null,
      dogPoint: null,
      dogImage: null,
      dogImage2: null,
      dogImage3: null,
      isChoice: false,
      choiceCount: 0,
      choiceDogs: null
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
      user.getChoiceUsers().then((response) => {
        this.choiceDogs = response
      })
      this.sex = userInfo.sex
      this.name = userInfo.name
      this.email = userInfo.email
      this.password = userInfo.password
      this.weight = userInfo.weight
      this.breed1 = userInfo.breed1
      this.breed2 = userInfo.breed2 ? userInfo.breed2 : null
      this.location = userInfo.location
      this.instagramId = userInfo.instagramId ? userInfo.instagramId : null
      this.twitterId = userInfo.twitterId ? userInfo.twitterId : null
      this.tiktokId = userInfo.tiktokId ? userInfo.tiktokId : null
      this.blogId = userInfo.blogId ? userInfo.blogId : null
      this.birthday = userInfo.birthday
      this.position = 2
    },
    async storeDogImage (dogImage) {
      this.dogImage = dogImage
      if (this.dogImage === null) {
        this.$store.dispatch('snackbar/setMessage', 'もう一度やり直してください。')
        this.$store.dispatch('snackbar/snackOn')
      } else {
        this.isChoice = true
      }
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
    },
    choiceLeft () {
      diagnosis.choice(this.choiceDogs[0].user_id, this.choiceDogs[1].user_id).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceDogs = response
        } else {
          this.requestSignup
        }
      })
    },
    choiceRight () {
      diagnosis.choice(this.choiceDogs[1].user_id, this.choiceDogs[0].user_id).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceDogs = response
        } else {
          this.requestSignup
        }
      })
    },
    clickAlertLeft () {
      diagnosis.alert(this.choiceDogs[0].user_id).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceDogs = response
        } else {
          this.requestSignup
        }
      })
    },
    clickAlertRight () {
      diagnosis.alert(this.choiceDogs[1].user_id).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceDogs = response
        } else {
          this.requestSignup
        }
      })
    },
    requestSignup () {
      this.$axios.get('/sanctum/csrf-cookie', { withCredentials: true })
      user.signup(
        this.sex,
        this.name,
        this.email,
        this.password,
        this.weight,
        this.breed1,
        this.breed2,
        this.instagramId,
        this.twitterId,
        this.tiktokId,
        this.blogId,
        this.dogImage,
        this.location,
        this.birthday
      ).then((response) => {
        this.isChoice = false
        this.position = 3
        this.$auth.setUserToken('200')
        this.$store.dispatch('authInfo/setAuthInfo', response)
        setTimeout(this.$router.push('/mypage'), 2000)
      })
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
