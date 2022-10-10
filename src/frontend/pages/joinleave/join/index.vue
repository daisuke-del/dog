<template>
  <div class="all"> 
    <h2>{{ title }}</h2>
    <form class="join-wrap">
      <div class="main-wrap">
        <v-text-field
        v-model="name"
        :error-messages="nameErrors"
        :counter="10"
        label="お名前"
        required
        light
        @input="$v.name.$touch()"
        @blur="$v.name.$touch()"
      ></v-text-field>
      <v-text-field
        v-model="email"
        :error-messages="emailErrors"
        label="メールアドレス"
        required
        light
        @input="$v.email.$touch()"
        @blur="$v.email.$touch()"
      ></v-text-field>
      <v-text-field
        v-model="password"
        :error-messages="passwordErrors"
        label="パスワード"
        required
        light
        @input="$v.email.$touch()"
        @blur="$v.email.$touch()"
      ></v-text-field>
      <v-text-field
        v-model="email"
        :error-messages="passwordErrors"
        label="確認パスワード"
        required
        light
        @input="$v.email.$touch()"
        @blur="$v.email.$touch()"
      ></v-text-field>
      <v-btn text to="/support/terms" class="small-text" target="_blank">
        利用規約
      </v-btn>
      <v-checkbox
        v-model="checkbox"
        :error-messages="checkboxErrors"
        label="利用規約に同意します"
        required
        light
        @change="$v.checkbox.$touch()"
        @blur="$v.checkbox.$touch()"
      ></v-checkbox>
      </div>
      <div class="btn-wrap">
        <button class="back-btn" @click="$router.back()">戻る</button>
        <button class="next-btn" @click="submit">次へ</button>
      </div>
    </form>
  </div>
</template>

<script>
import { validationMixin } from 'vuelidate'
import { required, maxLength, email } from 'vuelidate/lib/validators'
export default {
  mixins: [validationMixin],
  validations: {
    name: { required, maxLength: maxLength(10) },
    email: { required, email },
    select: { required },
    checkbox: {
      checked(val) {
        return val
      }
    }
  },
  name: 'JoinleaveJoin',
  data () {
    return {
    name: '',
    email: '',
    password: '',
    select: null,
    checkbox: false,
    title: '無料会員登録'
    }
  },
  computed: {
    checkboxErrors() {
      const errors = []
      if (!this.$v.checkbox.$dirty) return errors
      !this.$v.checkbox.checked && errors.push('You must agree to continue!')
      return errors
    },
    nameErrors() {
      const errors = []
      if (!this.$v.name.$dirty) return errors
      !this.$v.name.maxLength &&
        errors.push('Name must be at most 10 characters long')
      !this.$v.name.required && errors.push('Name is required.')
      return errors
    },
    emailErrors() {
      const errors = []
      if (!this.$v.email.$dirty) return errors
      !this.$v.email.email && errors.push('Must be valid e-mail')
      !this.$v.email.required && errors.push('E-mail is required')
      return errors
    },
  },

  methods: {
    submit() {
      this.$v.$touch()
    },
  },
}
</script>

<style scoped>
.all {
  text-align: center;
}

h2 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  margin: 20px;
}

.main-wrap {
  margin-left: 20%;
  margin-right: 20%;
  max-width: 800px;
}

.small-text {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
}

.join-wrap {
  margin-top: 50px;
}

.btn-wrap {
  margin-right: 20px;
}

.next-btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
  background-color: white;
  width: 100px;
  height: 30px;
  border-radius: 0.3em;
  outline: 1px solid #b9c9ce;
  margin: 30px 0 15px 15px;
}

.back-btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
  background-color: white;
  width: 100px;
  height: 30px;
  border-radius: 0.3em;
  outline: 1px solid #b9c9ce;
  margin: 30px 0 15px 15px;
}

.next-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

.back-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

@media screen and (min-width: 600px) {
  .btn-wrap {
    margin-right: 50px;
  }
}
</style>
