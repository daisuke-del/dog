<template>
  <div class="login-wrap px-4 mx-auto">
    <h3 class="headline-dog pt-10">
      <PawsIcon class="paws-icon headline-text" />
      <span class="headline-text"><a @click="pulsA">ログ</a><a @click="pulsB">イン</a></span>
    </h3>
    <admin-login v-if="admin === 'abbaabb'"/>
    <v-form ref="loginForm" v-else>
      <div class="main-wrap">
        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="メールアドレス"
          background-color="white"
          color="primary"
          required
          outlined
          light class="mail form-content"
        />
        <v-text-field
          v-model="password"
          :rules="passwordRules"
          :append-icon="isShowPassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="isShowPassword ? 'text' : 'password'"
          class="password form-content"
          label="パスワード"
          background-color="white"
          color="primary"
          required
          outlined
          light
        />
        <div class='btn-wrap'>
          <a
            class='btn-text blue-btn'
            @click="clickLogin()"
          >
            ログイン<v-icon color="white" class="btn-icon">mdi-chevron-right</v-icon>
          </a>
        </div>
        <h3 class="headline-dog pt-10">
          <PawsIcon class="paws-icon headline-text" />
          <span class="headline-text">初めてご利用の方はこちら</span>
        </h3>
        <div class="btn-wrap mt-10">
          <a
            class="white-btn white-btn-text"
            @click="$router.push('signup')"
          >
            会員登録
            <v-icon class="btn-icon black-icon">mdi-chevron-right</v-icon>
          </a>
        </div>
      </div>
    </v-form>
  </div>
</template>
<script>
import user from '@/plugins/modules/user'
import constants from '@/utils/constants'
import AdminLogin from '@/components/Login/AdminLogin'
import PawsIcon from "@/assets/image/svg/paws-icon.svg";

export default {
  components: {
    AdminLogin,
    PawsIcon
  },
  name: 'LoginForm',
  auth: false,
  asyncData({ app, $auth, redirect }) {
    if ($auth.loggedIn) {
      user.getUserInfo().then((response) => {
        app.store.dispatch('authInfo/setAuthInfo', response)
      })
      if (app.store.state.redirect.pageUrl) {
        redirect(app.store.redirect.pageUrl)
        app.store.dispatch('redirect/deletePageUrl')
      } else {
        app.router.replace('/mypage')
      }
    }
  },
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      vm.previousPage = from.path
    })
  },
  data () {
    return {
      email: null,
      password: null,
      isShowPassword: false,
      emailRules: [
        v => !!v || 'メールアドレスが入力されていません。',
        v => v == null || v.match(constants.mailValidation) != null || 'メールアドレスの形式ではありません。',
      ],
      passwordRules: [
        v => !!v || 'パスワードが入力されていません。',
        v => v == null || (v.length >= constants.minPasswordLength && v.length <= constants.maxPasswordLength) || 'パスワードは6～32文字で設定して下さい。'
      ],
      loginLoading: false,
      admin: ''
    }
  },
  methods: {
    async clickLogin () {
      if (this.$refs.loginForm.validate()) {
        this.loginLoading = true
        await this.$axios.get('/sanctum/csrf-cookie', { withCredentials: true })
        await user.login(this.email, this.password).then((response) => {
          this.$auth.setUserToken('200')
          this.$store.dispatch('authInfo/setAuthInfo', response.data)
          this.$router.replace('/mypage')
        }).finally(() => {
          this.loginLoading = false
        })
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
    pulsA () {
      this.admin = this.admin + 'a'
    },
    pulsB () {
      this.admin = this.admin + 'b'
    }
  }
}
</script>

<style scoped>
.headline-dog {
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: left;
  color: #505050;
}

.headline-text {
  vertical-align: middle;
}

a {
  text-decoration: none;
  color: #505050;
  cursor: default;
}

.login-wrap {
  max-width: 450px;
}

.btn-wrap {
  margin-bottom: 30px;
}

.btn-wrap {
  text-align: center;
}

.btn-text {
  border-radius: 30px;
  color: white;
  padding: 15px;
  display: inline-block;
  font-weight: bolder;
  max-width: 600px;
  min-width: 200px;
  font-size: 1.1em;
}

.white-btn-text {
  border-radius: 30px;
  color: #505050;
  padding: 15px;
  display: inline-block;
  font-weight: bolder;
  max-width: 600px;
  min-width: 200px;
  font-size: 1.1em;
}

.blue-btn {
  background-color: #84D1E2;
  max-width: 600px;
  width: 100%;
  padding-top: 20px;
  padding-bottom: 20px;
}

.white-btn {
  background-color: #ffffff;
  max-width: 600px;
  width: 100%;
  padding-top: 16px;
  padding-bottom: 16px;
  border: 4px solid;
  border-color: #84D1E2;
}

.btn-icon {
  margin-bottom: 2px;
}

.black-icon {
  color: #505050;
}

@media screen and (min-width: 600px) {

  .headline-text {
    font-size: 1.5em;
  }

  .paws-icon {
    width: 1.5em;
    height: 1.5em;
  }
}
</style>