<template>
  <div class="login-wrap mx-auto">
    <h1>ログイン</h1>
    <v-form ref="loginForm">
      <div class="main-wrap">
        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="メールアドレス"
          background-color="white"
          required
          outlined
          light
          class="mail form-content"
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
          elevation="0"
          color="#fd7e00"
          class="font-weight-bold mb-1"
          @click="clickLogin"
        >
          ログイン
        </v-btn>
        <div class="d-flex justify-center">
          <v-btn
            text
            light
            class="mb-3"
          >
            パスワードを忘れた方
          </v-btn>
        </div>
        <v-btn
          block
          height="40px"
          elevation="0"
          color="#0067c0"
          class="font-weight-bold"
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
export default {
  name: 'LoginForm',
  auth: false,
  asyncData ({ app, $auth, redirect }) {
    if ($auth.loggedIn) {
      if (app.store.state.redirect.pageUrl) {
        redirect(app.store.state.redirect.pageUrl)
        app.store.dispatch('redirect/deletePageUrl')
      } else {
        app.router.replace('/my')
      }
    }
  },
  beforeRouteEnter (to, from, next) {
    next((vm) => {
      vm.previousPage = from.fullPath
    })
  },
  data () {
    return {
      email: null,
      password: null,
      isShowPassword: false,
      sendLoading: false,
      emailRules: [
        v => !!v || 'メールアドレスが入力されていません。',
        v => v == null || v.match(constants.mailValidation) != null || 'メールアドレスの形式ではありません。',
      ],
      passwordRules: [
        v => !!v || 'パスワードが入力されていません。',
        v => v == null || (v.length >= constants.minPasswordLength && v.length <= constants.maxPasswordLength) || 'パスワードは6～32文字で設定して下さい。'
      ]
    }
  },
  methods: {
    clickLogin () {
      if (this.$refs.loginForm.validate()) {
        this.loginLoading = true
        try {
          const response = user.login.then(() => {
            window.alert('ログインしました');
            const redirectUrl = this.$store.state.redirect.pageUrl
            if (redirectUrl) {
              this.$router.replace(redirectUrl)
              this.$store.dispatch('redirect/deletePageUrl')
            }
            });
        } catch (error) {
          window.alert("ログイン失敗");
          this.loginLoading = false
        }
      }
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

.login-wrap {
  padding: 10px 20px;
  max-width: 450px;
}

.btn-wrap {
  margin-bottom: 30px;
}
</style>