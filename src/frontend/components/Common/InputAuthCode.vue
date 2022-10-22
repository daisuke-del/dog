<template>
  <div>
    <p class="message">
      メールアドレスへ送信された認証コードを入力してください
    </p>
    <div class="auth-code">
      <label class="number-wrap">
        <input
          v-for="(input, index) in length"
          :id="generateInputId(index)"
          :ref="generateInputId(index)"
          :key="index"
          v-model="inputValues[index]"
          class="number"
          type="tel"
          maxlength="1"
          autocomplete="off"
          oninput="value = value.replace(/[^0-9]+/i,'');"
          @keyup="handleInputFocus(index, $event)"
          @input="numberInput"
        >
      </label>
      <p v-if="errorShow" class="my-4">
        認証コードが違います。
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    errorShow: {
      type: Boolean,
      required: true
    }
  },
  data () {
    return {
      inputValues: [],
      length: 6
    }
  },
  methods: {
    generateInputId (index) {
      return `item-${index + 1}`
    },
    handleInputFocus (index, event) {
      if (this.inputValues[index] && this.inputValues[index] !== '' && index < this.length -1) {
        const [nextInput] = this.$refs[`item-${index + 2}`]
        nextInput.focus()
      } else if (index > 0 && (!this.inputValues[index] || this.inputValues[index] === '') && event.key === 'Backspace') {
        const [previusInput] = this.$refs[`item-${index}`]
        previusInput.focus()
      }
    },
    numberInput () {
      this.$emit('input', this.inputValues.join(''))
    },
    initializeInput () {
      this.inputValues = []
      const [firstInput] = this.$refs.item_1
      firstInput.focus()
    }
  }
}
</script>

<style scoped>
input {
  border: none;
  text-align: center;
}

.message {
  text-align: center;
  margin-top: 20px;
}

.auth-code {
  text-align: center;
}

.auth-code p {
  color: red;
}

.number {
  border-radius: 5px;
  border: 1px solid #c4c4c4;
  font-size: 22px;
  width: 45px;
  height: 45px;
  margin: 20px 2px;
}

#item-4 {
  margin-left: 13px;
}
</style>