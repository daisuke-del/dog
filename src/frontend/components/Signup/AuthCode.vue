<template>
  <div>
    <input-auth-code
      ref="inputAuthCode"
      :error-show="errorShow"
      @input="numberInput"
    />
    <div class="btn-wrap mt-4">
      <v-btn
        v-if="sendButtonShow"
        block
        depressed
        height="50px"
        color="primary"
        class="btn"
        @click="sendAuthCode"
      >
        認証コードを送信する
      </v-btn>
      <v-btn
        block
        depressed
        height="50px"
        color="#c4c4c4"
        class="btn mt-3"
        @click="clickBack"
      >
        戻る
      </v-btn>
    </div>
  </div>
</template>
<script>
import InputAuthCode from '~/components/Common/InputAuthCode'
export default {
  components: {
    InputAuthCode
  },
  props: {
    errorShow: {
      type: Boolean,
      required: true
    },
    sendLoading: {
      type: Boolean,
      required: true
    },
    sendButtonShow: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    numberInput (inputValue) {
      this.$emit('input', inputValue)
    },
    sendAuthCode () {
      this.$refs.inputAuthCode.numberInput()
    },
    clickBack () {
      this.$emit('click-back', 3)
    },
    onErrorAuthCode () {
      this.$refs.inputAuthCode.initializeInput()
    }
  }
}
</script>

<style scoped>
.btn-wrap {
  text-align: center;
  width: 300px;
  margin: 0 auto;
}
.btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 16px;
  font-weight: bolder;
}
</style>