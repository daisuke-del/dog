<template>
  <div class="all">
    <p class="big-text d-flex justify-center">身長を入力してください</p>
    <div class="height-wrap">
      <label>
        <input v-for="(input, index) in length" :id="generateInputNum(index)" :ref="generateInputNum(index)"
          :key="index" v-model="inputValues[index]" class="number" type="tel" maxlength="1" autocomplete="off"
          oninput="value = value.replace(/[^0-9]+/i,'');" @keyup="handleInputFocus(index, $event)"
          @input="numberInput()">
      </label>
      <p class="height-text big-text">cm</p>
    </div>
    <v-btn
      text
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
  name: 'DiagnosisHeight',
  data () {
    return {
      inputValues: [1],
      length: 3
    }
  },
  methods: {
    generateInputNum (index) {
      return `item_${index + 1}`
    },
    handleInputFocus (index, event) {
      if (this.inputValues[index] && this.inputValues[index] !== '' && index < this.length - 1) {
        const [nextInput] = this.$refs[`item_${index + 2}`]
        nextInput.focus()
      } else if (index > 0 && (!this.inputValues[index] || this.inputValues[index] === '') && event.key === 'Backspace') {
        const [previusInput] = this.$refs[`item_${index}`]
        previusInput.focus()
      }
    },
    numberInput () {
      this.$emit('click-height', this.inputValues.join(''))
    },
    clickBack () {
      this.$emit('click-back', 1)
    },
    resetHeight () {
      this.inputValues = [1]
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

.height-wrap {
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

.height-text {
  display: inline-block;
  margin: 0;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 1.8em;
    color: #505050;
  }

  .height-wrap {
    margin-top: 50px;
  }

  .number {
    height: 80px;
    max-width: 80px;
    margin: 8px;
    font-size: 1.8em;
  }

  .height-text {
    margin-left: 10px;
  }
}
</style>