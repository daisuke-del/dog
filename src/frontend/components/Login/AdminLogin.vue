<template>
    <div class="login-wrap mx-auto">
      <v-form ref="adminLoginForm">
        <div class="main-wrap">
          <v-text-field v-model="email" :rules="emailRules" label="メールアドレス" background-color="white" required outlined
            light class="mail form-content" />
          <v-text-field v-model="password" :rules="passwordRules"
            :append-icon="isShowPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="isShowPassword ? 'text' : 'password'"
            class="password form-content" label="パスワード" background-color="white" required outlined light />
          <v-btn block height="40px" elevation="0" color="#fd7e00" :loading="adminLoginLoading" class="font-weight-bold mb-8" @click="clickAdminLogin">
            ログイン
          </v-btn>
        </div>
      </v-form>
    </div>
  </template>
  <script>
  import admin from '@/plugins/modules/admin'
  import constants from '@/utils/constants'
  export default {
    name: 'AdminLogin',
    auth: false,
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
        adminLoginLoading: false,
      }
    },
    methods: {
      async clickAdminLogin() {
        if (this.$refs.adminLoginForm.validate()) {
          this.adminLoginLoading = true
          await this.$axios.get('/sanctum/csrf-cookie', { withCredentials: true })
          await admin.login(this.email, this.password).then((response) => {
            this.$auth.setUserToken('200')
            this.$store.dispatch('adminInfo/setAdminInfo', 1)
            this.$store.dispatch('authInfo/setAuthInfo', response)
            this.$router.replace('/admin/backoffice')
          }).catch(() => {
            this.adminLoginLoading = false
          })
        }
      },
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
  </style>