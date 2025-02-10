<template>
  <div class="all">
    <p class="big-text d-flex justify-center">体重を入力してください</p>
    <div class="weight-wrap">
      <label>
        <input
          v-for="(input, index) in length"
          :id="generateInputNum(index)"
          :ref="generateInputNum(index)"
          :key="index"
          v-model="inputValues[index]"
          class="number"
          type="tel"
          maxlength="1"
          autocomplete="off"
          oninput="value = value.replace(/[^0-9]+/i,'');"
          @keyup="handleInputFocus(index, $event)"
          @input="numberInput()"
        >
      </label>
      <p class="weight-text big-text">kg</p>
    </div>
    <v-btn
      text
      large
      :x-large="$vuetify.breakpoint.smAndUp"
      color="primary"
      @click="clickBack()"
      class="mt-4"
    >
      戻る
    </v-btn>
  </div>
</template>

<script>
export default {
  name: 'DiagnosisWeight',
  data () {
    return {
      inputValues: [0],
      length: 3
    }
  },
  methods: {
    generateInputNum (index) {
      return `item_${index + 1}`
    },
    handleInputFocus (index, event) {
      if (this.inputValues[index] && this.inputValues[index] !== '' && index < this.length -1) {
        const [nextInput] = this.$refs[`item_${index + 2}`]
        nextInput.focus()
      } else if (index > 0 && (!this.inputValues[index] || this.inputValues[index] === '') && event.key === 'Backspace') {
        const [previusInput] = this.$refs[`item_${index}`]
        previusInput.focus()
      }
    },
    numberInput () {
      this.$emit('click-weight', this.inputValues.join(''))
    },
    clickBack () {
      this.$emit('click-back', 2)
    },
    resetWeight () {
      this.inputValues = [0]
    },
    focusInput () {
      this.$refs.item_2[0].focus()
    }
  }
}
</script>

<style scoped>
.all {
  margin-right: 20px;
}

.big-text {
  font-size: 1.2em;
  color: #505050;
  font-weight: bold;
}

.weight-wrap {
  padding-top: 30px;
  text-align: center;
}

.number {
  border: 1px solid #505050;
  border-radius: 20%;
  height: 50px;
  max-width: 50px;
  margin: 3px;
  font-size: 1.7em;
  text-align: center;
  color: #505050;
}

.weight-text {
  display: inline-block;
  margin: 0;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 1.8em;
    color: #505050;
  }

  .weight-wrap {
    margin-top: 50px;
  }

  .number {
    height: 80px;
    max-width: 80px;
    margin: 8px;
    font-size: 1.8em;
  }
}
</style>
