<template>
  <div> 
    <form>
      <div class="main-wrap">
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
        <v-text-field
          v-model="name"
          :error-messages="nameErrors"
          :counter="10"
          class="name form-content"
          label="ニックネーム(ヤマダユウキ)"
          required
          light
          @input="$v.name.$touch()"
          @blur="$v.name.$touch()"
        ></v-text-field>
        <v-text-field
          v-model="email"
          :error-messages="emailErrors"
          class="mail form-content"
          label="メールアドレス(example@gmail.com)"
          required
          light
          @input="$v.email.$touch()"
          @blur="$v.email.$touch()"
        ></v-text-field>
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
        ></v-text-field>
        <div class="height d-flex justify-center form-content">
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
              @input="heightNumberInput('height')"
            >
            <span>cm</span>
          </label>
        </div>
        <div class="weight d-flex justify-center form-content">
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
              @input="weightNumberInput()"
            >
            <span>kg</span>
          </label>
        </div>
        <div class="age d-flex justify-center form-content">
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
              @input="ageNumberInput()"
            >
            <span>歳</span>
          </label> 
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
        <div class="support-wrap d-flex justify-center">
          <v-btn text to="/support/terms" class="small-text" target="_blank">
          利用規約を確認
          </v-btn>
        </div>
        <div class="d-flex justify-center">
          <v-checkbox
            v-model="checkbox"
            :error-messages="checkboxErrors"
            class="checkbox"
            label="利用規約に同意します"
            required
            light
            @change="$v.checkbox.$touch()"
            @blur="$v.checkbox.$touch()"
          ></v-checkbox>
        </div>
        <div class="btn-wrap">
          <send-user-info-button
            :send-loading="sendLoading"
            @send-user-info="storeUserInfo"
          />
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { validationMixin } from 'vuelidate'
import { required, maxLength, email } from 'vuelidate/lib/validators'
import SendUserInfoButton from '~/components/Common/SendUserInfoButton'
export default {
  name: 'SignupForm',
  components: {
    SendUserInfoButton
  },
  mixins: [validationMixin],
  validations: {
    name: { required, maxLength: maxLength(10) },
    email: { required, email },
    password: { required },
    select: { required },
    checkbox: {
      checked(val) {
        return val
      }
    }
  },
  data () {
    return {
      isToggled: false,
      whichGender: true,
      gender: '',
      name: '',
      email: '',
      password: '',
      isShowPassword: true,
      heightValues: [1],
      weightValues: [0],
      ageValues: [0],
      salaryValues: [],
      select: null,
      checkbox: false,
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
    }
  },
  computed: {
    checkboxErrors () {
      const errors = []
      if (!this.$v.checkbox.$dirty) return errors
      !this.$v.checkbox.checked && errors.push('利用規約の同意は必須項目です。')
      return errors
    },
    nameErrors () {
      const errors = []
      if (!this.$v.name.$dirty) return errors
      !this.$v.name.maxLength &&
        errors.push('ニックネーム10文字以内です。')
      !this.$v.name.required && errors.push('ニックネームは必須項目です。')
      return errors
    },
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
    heightNumberInput () {
      this.$emit('input-height', this.heightValues.join(''))
    },
    weightNumberInput () {
      this.$emit('input-weight', this.weightValues.join(''))
    },
    ageNumberInput () {
      this.$emit('input-age', this.ageValues.join(''))
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
      this.$emit('click-salary', this.salary)
    },
    storeUserInfo () {
      console.log('a')
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
        height: this.height,
        weight: this.weight, 
        age: this.age, 
        salary: this.salary
      })
    }
  }
}
</script>

<style scoped>
span {
  font-size: 20px;
}

.main-wrap {
  margin: 0 auto;
  max-width: 480px;
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
</style>
