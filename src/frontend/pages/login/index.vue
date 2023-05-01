<template>
  <div class="login-wrap mx-auto">
    <h1><a @click="pulsA">ログ</a><a @click="pulsB">イン</a></h1>
    <admin-login v-if="admin === 'abbaabb'"/>
    <v-form ref="loginForm" v-else>
      <div class="main-wrap">
        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="メールアドレス"
          background-color="white"
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
          required
          outlined
          light
        />
        <v-btn
          block
          height="40px"
          depressed
          color="primary"
          :loading="loginLoading"
          class="font-weight-bold mb-8 btn"
          @click="clickLogin"
        >
          ログイン
        </v-btn>
        <v-btn
          block
          height="40px"
          depressed
          color="accent"
          class="font-weight-bold mb-5 btn"
          @click="$router.push('signup')"
        >
          会員登録
        </v-btn>
      </div>
    </v-form>
  </div>
</template>
<script>
import user from '@/plugins/modules/user'
import constants from '@/utils/constants'
import AdminLogin from '@/components/Login/AdminLogin'
export default {
  components: { AdminLogin },
  name: 'LoginForm',
  auth: false,
  asyncData({ app, $auth, redirect }) {
    if ($auth.loggedIn) {
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
  data() {
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
    async clickLogin() {
      if (this.$refs.loginForm.validate()) {
        this.loginLoading = true
        await this.$axios.get('/sanctum/csrf-cookie', { withCredentials: true })
        await user.login(this.email, this.password).then((response) => {
          this.$auth.setUserToken('200')
          this.$store.dispatch('authInfo/setAuthInfo', response.data)
          this.$router.replace('/mypage')
        }).catch(() => {
          this.loginLoading = false
        })
      }
    },
    redirect() {
      const redirectUrl = this.$store.state.redirect.pageUrl
      if (redirectUrl) {
        this.$router.replace(redirectUrl)
      } else {
        this.$route.replace("/")
      }
      this.$store.dispatch('redirect/deletePageUrl')
    },
    pulsA() {
      this.admin = this.admin + 'a'
    },
    pulsB() {
      this.admin = this.admin + 'b'
    }
  }
}
</script>

<style scoped>
h1 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  margin: 20px;
  text-align: center;
}

a {
  text-decoration: none;
  color: dimgrey;
  cursor: default;
}

.login-wrap {
  padding: 10px 20px;
  max-width: 450px;
}

.btn-wrap {
  margin-bottom: 30px;
}

.btn {
  color: #fff;
}
</style>