<template>
  <div class="button">
    <v-btn
      class="submit-button"
      depressed
      block
      color="primary"
      height="55px"
      :loading="sendLoading"
      @click="clickSendUserInfo"
    >
      <v-icon left>
        mdi-email-outline
      </v-icon>
      入力内容を送信
    </v-btn>
  </div>
</template>

<script>
export default {
  props: {
    sendLoading: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    clickSendUserInfo () {
      this.$emit('send-user-info')
    }
  }
}
</script>

<style scoped>
.submit-button {
  font-weight: bolder;
  font-size: 16px;
}
</style>