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
  data () {
    return {
      email: '',
      password: '',
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
    //
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