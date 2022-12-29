<template>
  <div>
    <h1>{{ title }}</h1>
    <form>
      <div class="main-wrap">
        <v-text-field
          v-model="email"
          :error-messages="emailErrors"
          class="mail form-content"
          label="メールアドレス(example@gmail.com)"
          required
          light
          @input="$v.email.$touch()"
          @blur="$v.email.$touch()"
        />
        <v-text-field
          v-model="password"
          :error-messages="passwordErrors"
          :append-icon="isShowPassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="isShowPassword ? 'text' : 'password'"
          class="password form-content"
          label="パスワード"
          required
          light
          @input="$v.password.$touch()"
          @blur="$v.password.$touch()"
        />
        <div class="btn-wrap">
          <send-user-info-button
            :send-loading="sendLoading"
            @send-user-info="clickLogin"
          />
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import { validationMixin } from 'vuelidate'
import { required, maxLength, email } from 'vuelidate/lib/validators'
import user from '@/plugins/modules/user'
export default {
  name: 'LoginForm',
  components: {
    SendUserInfoButton
  },
  mixins: [validationMixin],
  validations: {
    name: { required, maxLength: maxLength(10) },
    email: { required, email },
    password: { required },
  },
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
      isShowPassword: true,
      title: 'ログイン',
      sendLoading: false,
    }
  },
  computed: {
    emailErrors () {
      const errors = []
      if (!this.$v.email.$dirty) return errors
      !this.$v.email.email && errors.push('メールアドレスの形式に誤りがあります。')
      !this.$v.email.required && errors.push('メールアドレスは必須項目です。')
      return errors
    },
    passwordErrors () {
      const errors = []
      if (!this.$v.password.$dirty) return errors
      !this.$v.password.required && errors.push('パスワードは必須項目です。')
      return errors
    }
  },
  clickLogin () {
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
      console.log(response);
    } catch (error) {
      window.alert("ログイン失敗");
      console.log(error);
      this.loginLoading = false
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

.btn-wrap {
  margin-bottom: 30px;
}
</style>