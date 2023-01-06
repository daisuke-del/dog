<template>
  <div>
    <div class="gender">
      <toggle-button
        v-model="whichGender"
        :color="{checked: '#99ccff', unchecked: '#ECA5B2'}"
        :labels="{checked: '男性', unchecked: '女性'}"
        :switch-color="{checked: '#0099ff', unchecked: '#FFC0CB'}"
        :font-size="15"
        :width="80"
        :height="30"
      />
    </div>
    <v-form ref="signupForm" class="signup-form-wrap">
      <div class="main-wrap">
        <v-text-field
          v-model="name"
          :rules="nameRules"
          :counter="10"
          class="name form-content"
          label="ニックネーム(ヤマダユウキ)"
          required
          light
        />
        <v-text-field
          v-model="email"
          :rules="emailRules"
          class="mail form-content"
          label="メールアドレス(example@gmail.com)"
          required
          light
        />
        <v-text-field
          v-model="password"
          :rules="passwordRules"
          :append-icon="isShowPassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="isShowPassword ? 'text' : 'password'"
          class="password form-content"
          label="パスワード"
          required
          light
        />
        <div class="height form-content">
          <label>
            <span>身長</span>
            <input
              v-for="(input, index) in 3"
              :id="generateInputNum('height', index)"
              :ref="generateInputNum('height', index)"
              :key="'height' + index"
              v-model="heightValues[index]"
              class="number"
              type="tel"
              maxlength="1"
              autocomplete="off"
              required
              oninput="value = value.replace(/[^0-9]+/i,'');"
              @keyup="heightHandleInputFocus(index, $event)"
            >
            <span>cm</span>
          </label>
          <p v-if="heightErrorShow" class="error-message">
            身長は３桁の半角数字で入力してください。例:180
          </p>
        </div>
        <div class="weight form-content">
          <label>
            <span>体重</span>
            <input
              v-for="(input, index) in 3"
              :id="generateInputNum('weight', index)"
              :ref="generateInputNum('weight', index)"
              :key="'weight' + index"
              v-model="weightValues[index]"
              class="number"
              type="tel"
              maxlength="1"
              autocomplete="off"
              required
              oninput="value = value.replace(/[^0-9]+/i,'');"
              @keyup="weightHandleInputFocus(index, $event)"
            >
            <span>kg</span>
          </label>
          <p v-if="weightErrorShow" class="error-message">
            体重は３桁の半角数字で入力してください。例:060
          </p>
        </div>
        <div class="age form-content">
          <label>
            <span>年齢</span>
            <input
              v-for="(input, index) in 3"
              :id="generateInputNum('age', index)"
              :ref="generateInputNum('age', index)"
              :key="'age' + index"
              v-model="ageValues[index]"
              class="number"
              type="tel"
              maxlength="1"
              autocomplete="off"
              required
              oninput="value = value.replace(/[^0-9]+/i,'');"
              @keyup="ageHandleInputFocus(index, $event)"
            >
            <span>歳</span>
          </label>
          <p v-if="ageErrorShow" class="error-message">
            年齢は３桁の半角数字で入力してください。例:030
          </p>
        </div>
        <label class="salary-wrap d-flex justify-center form-content">
          <span>
            <v-select
              v-model="item"
              class="salary-box"
              :items="salaryRange"
              label="年収を選択"
              hide-details
              prepend-icon="mdi-currency-jpy"
              outlined
            />
          </span>
          <span class="salary-text">万円</span>
        </label>
        <p v-if="salaryErrorShow" class="error-message">
          年収を選択してください。
        </p>
        <div class="support-wrap d-flex justify-center">
          <v-btn text to="/support/terms" class="small-text" target="_blank">
            利用規約を確認
          </v-btn>
        </div>
        <div class="d-flex justify-center">
          <v-checkbox
            v-model="checkbox"
            class="checkbox"
            label="利用規約に同意します"
            required
            light
            hide-details=false
          />
        </div>
        <p v-if="agreeErrorShow" class="error-message">
          利用規約に同意が必須です。
        </p>
        <v-btn
          block
          dark
          height="40px"
          elevation="0"
          color="#fd7e00"
          class="font-weight-bold"
          @click="storeUserInfo"
        >
          入力項目を送信
        </v-btn>
      </div>
    </v-form>
  </div>
</template>

<script>
import constants from '@/utils/constants'
export default {
  name: 'SignupForm',
  data () {
    return {
      isToggled: false,
      whichGender: true,
      gender: null,
      name: null,
      email: null,
      password: null,
      isShowPassword: true,
      heightValues: [1],
      weightValues: [0],
      ageValues: [0],
      select: null,
      checkbox: null,
      title: '無料会員登録',
      sendLoading: false,
      salaryRange: [
          '〜 199',
          '200 〜 399',
          '400 〜 599',
          '600 〜 799',
          '800 〜 999',
          '1000 〜 1999',
          '2000 〜 2999',
          '3000 〜',
        ],
      item: null,
      salary: null,
      nameRules: [
        v => !!v || 'ニックネームは必須項目です',
        v => v == null || (v.length <= constants.maxNameLength) || 'ニックネームは10文字以内で入力して下さい。'
      ],
      emailRules: [
        v => !!v || 'メールアドレスが入力されていません。',
        v => v == null || v.match(constants.mailValidation) != null || 'メールアドレスの形式ではありません。',
      ],
      passwordRules: [
        v => !!v || 'パスワードが入力されていません。',
        v => v == null || (v.length >= constants.minPasswordLength && v.length <= constants.maxPasswordLength) || 'パスワードは6～32文字で設定して下さい。'
      ],
      heightErrorShow: false,
      weightErrorShow: false,
      ageErrorShow: false,
      salaryErrorShow: false,
      agreeErrorShow: false
    }
  },
  methods: {
    generateInputNum (item, index) {
      return `${item}_${index + 1}`
    },
    heightHandleInputFocus (index, event) {
      if (this.heightValues[index] && this.heightValues[index] !== '' && index < 2) {
        const [nextInput] = this.$refs[`height_${index + 2}`]
        nextInput.focus()
      } else if (index > 0 && (!this.heightValues[index] || this.heightValues[index] === '') && event.key === 'Backspace') {
        const [previusInput] = this.$refs[`height_${index}`]
        previusInput.focus()
      }
    },
    weightHandleInputFocus (index, event) {
      if (this.weightValues[index] && this.weightValues[index] !== '' && index < 2) {
        const [nextInput] = this.$refs[`weight_${index + 2}`]
        nextInput.focus()
      } else if (index > 0 && (!this.weightValues[index] || this.weightValues[index] === '') && event.key === 'Backspace') {
        const [previusInput] = this.$refs[`weight_${index}`]
        previusInput.focus()
      }
    },
    ageHandleInputFocus (index, event) {
      if (this.ageValues[index] && this.ageValues[index] !== '' && index < 2) {
        const [nextInput] = this.$refs[`age_${index + 2}`]
        nextInput.focus()
      } else if (index > 0 && (!this.ageValues[index] || this.ageValues[index] === '') && event.key === 'Backspace') {
        const [previusInput] = this.$refs[`age_${index}`]
        previusInput.focus()
      }
    },
    clickSalary () {
      if (this.item === '〜 199') {
        this.salary = 150
      } else if (this.item === '200 〜 399') {
        this.salary = 300
      } else if (this.item === '400 〜 599') {
        this.salary = 500
      } else if (this.item === '600 〜 799') {
        this.salary = 700
      } else if (this.item === '800 〜 999') {
        this.salary = 900
      } else if (this.item === '1000 〜 1999') {
        this.salary = 1100
      } else if (this.item === '2000 〜 2999') {
        this.salary = 1300
      } else if (this.item === '3000 〜') {
        this.salary = 1500
      }
    },
    storeUserInfo () {
      if (this.$refs.signupForm.validate() && this.item != null && this.heightValues.length === 3 && this.weightValues.length === 3 && this.ageValues.length === 3 && this.checkbox != null) {
        if (this.gender === true) {
          this.gender = 'male'
        } else {
          this.gender = 'female'
        }
        this.$emit('store-user-info', {
          gender: this.gender,
          name: this.name,
          mail: this.email,
          password: this.password,
          height: this.heightValues.join(''),
          weight: this.weightValues.join(''),
          age: this.ageValues.join(''),
          salary: this.salary
        })
      }
      if (this.heightValues.length != 3) {
        console.log(this.heightValues.length)
        this.heightErrorShow = true
      }
      if (this.weightValues.length != 3) {
        console.log(this.weightValues.length)
        this.weightErrorShow = true
      }
      if (this.ageValues.length != 3) {
        console.log(this.ageValues.length)
        this.ageErrorShow = true
      }
      if (this.item === null) {
        console.log(this.item)
        this.salaryErrorShow = true
      }
      if (this.checkbox != true) {
        console.log(this.checkbox)
        this.agreeErrorShow = true
      }
    }
  }
}
</script>

<style scoped>
span {
  font-size: 20px;
}

.signup-form-wrap {
  padding-bottom: 30px;
  text-align: center;
}

.main-wrap {
  margin: 0 auto;
  max-width: 400px;
}

.form-content {
  margin-bottom: 20px;
}

.gender {
  margin-top: 10px;
  margin-bottom: 20px;
}

.small-text {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  font-weight: bold;
  color: slategray;
}

.salary-box {
  max-width: 250px;
}

.salary-text {
  margin-top: 15px;
  margin-left: 10px;
}

.number {
  border: 2px solid #b9c9ce;
  border-radius: 5px;
  height: 60px;
  max-width: 60px;
  margin: 8px;
  font-size: 1.7em;
  text-align: center;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.support-wrap {
  text-align: center;
}

.checkbox {
  text-align: center;
  margin-bottom: 10px;
}

.btn-wrap {
  margin-bottom: 30px;
}

.error-message {
  color: #DD2C00;
  font-size: 12px;
}
</style>
