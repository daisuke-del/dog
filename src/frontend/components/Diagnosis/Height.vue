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
    <div class="btn-wrap">
      <button class="back-btn" @click="clickBack()">戻る</button>
    </div>
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
  font-size: 1.3em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.height-wrap {
  text-align: center;
}

.number {
  border: 2px solid #B9C9CE;
  border-radius: 5px;
  height: 50px;
  max-width: 50px;
  margin: 3px;
  font-size: 1.7em;
  text-align: center;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.height-text {
  display: inline-block;
  margin: 0;
}

.btn-wrap {
  text-align: center;
}

.back-btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
  background-color: white;
  width: 100px;
  height: 30px;
  border-radius: .3em;
  outline: 1px solid #B9C9CE;
  margin: 20px 17px 5px 0;
}

.back-btn:hover {
  outline: none;
  border: 2px solid #B9C9CE;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2.3em;
  }

  .height-wrap {
    margin-top: 50px;
  }

  .number {
    height: 100px;
    max-width: 100px;
    margin: 10px;
    font-size: 2.5em;
  }

  .height-text {
    margin-left: 10px;
  }

  .back-btn {
    font-size: 1.5em;
    width: 200px;
    height: 50px;
  }

  .btn-wrap {
    margin-top: 30px;
    margin-right: 30px;
  }
}
</style>