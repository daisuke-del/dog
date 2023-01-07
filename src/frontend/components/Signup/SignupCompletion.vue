<template>
  <div>
    <div class="message">
      <p class="complete-text ma-0">
        会員登録が完了しました！
      </p>
      <div class="icon-wrap d-flex justify-center">
        <v-img
          :src="check_icon"
          max-width="100px"
        />
      </div>
      <div class="btn-wrap">
        <v-btn
          block
          depressed
          color="primary"
          height="50px"
          class="btn"
          @click="mypageClick"
        >
          マイページへ
        </v-btn>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SignupCompletion',
  data () {
    return {
      check_icon: "~/assets/image/icons/check.png"
    }
  },
  methods: {
    mypageClick () {
      this.$emit('mypage')
    }
  }
}
</script>

<style scoped>
.message {
  text-align: center;
  width: 300px;
  margin: 0 auto;
}

.btn-wrap {
  text-align: center;
  max-width: 300px;
  margin: 0 auto;
}

.icon-wrap {
  margin: 30px 0;
}

.btn {
  font-size: 16px;
  font-weight: bolder;
}

.complete-text {
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
  font-size: 1.5em;
  font-weight: bolder;
}
</style>
