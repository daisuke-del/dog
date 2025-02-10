<template>
  <div class="all">
    <p class="result-text">あなたの犬種は....</p>
    <template v-if="diagnosisResult.length === 0 || !diagnosisResult">
      <h1 class="result-text">該当なし</h1>
    </template>
    <template v-else>
      <h1 class="result-dog-text">{{ diagnosisResult[0].name }}</h1>
      <v-card class="card" max-width="450px">
        <v-img
          class="result-image"
          :src="resultImage"
        />
        <div class="mt-4">
          <v-card-subtitle>グループ：{{ diagnosisResult[0].group }} / サイズ：{{ diagnosisResult[0].size }}</v-card-subtitle>
        </div>
        <div class="d-flex justify-center">
          <v-card-subtitle v-if="diagnosisResult[0].max_width && diagnosisResult[0].min_width">体長：{{ diagnosisResult[0].min_width }}cm~{{ diagnosisResult[0].max_width }}cm</v-card-subtitle>
          <v-card-subtitle v-else-if="!diagnosisResult[0].max_width">体長：{{ diagnosisResult[0].min_width }}cm~</v-card-subtitle>
          <v-card-subtitle v-else-if="!diagnosisResult[0].min_width">体長：~{{ diagnosisResult[0].max_width }}cm</v-card-subtitle>
          <v-card-subtitle v-if="diagnosisResult[0].max_weight && diagnosisResult[0].min_weight">体重：{{ diagnosisResult[0].min_weight / 1000 }}kg~{{ diagnosisResult[0].max_weight / 1000 }}kg</v-card-subtitle>
          <v-card-subtitle v-else-if="!diagnosisResult[0].max_weight">体重：{{ diagnosisResult[0].min_weight / 1000 }}kg~</v-card-subtitle>
          <v-card-subtitle v-else-if="!diagnosisResult[0].min_weight">体重~{{ diagnosisResult[0].max_weight / 1000 }}kg</v-card-subtitle>
        </div>
        <h3 class="result-headline">性格</h3>
        <v-card-text class="result-textfield">{{ diagnosisResult[0].personal }}</v-card-text>
        <h3 class="result-headline">特徴</h3>
        <v-card-text class="result-textfield">{{ diagnosisResult[0].character }}</v-card-text>
      </v-card>
      <v-btn
        block
        height="40px"
        depressed
        color="primary"
        class="font-weight-bold mb-10 mt-5"
        @click="reTry"
      >
        もう一度診断する
      </v-btn>
    </template>
  </div>
</template>

<script>
export default {
  name: 'DiagnosisResult',
  props: {
    diagnosisResult: {
      type: Array,
      requred: false
    }
  },
  computed: {
    resultImage () {
        return this.diagnosisResult[0].dog_image && require(`@/assets/image/breed/${this.diagnosisResult[0].dog_image}`)
    },
  },
  methods: {
    reTry() {
      this.$router.go({path: this.$router.currentRoute.path, force: true})
    }
  }
}
</script>

<style scoped>
.card {
  margin: 0 auto;
}

.v-card__subtitle {
  padding: 8px;
  font-size: 18px;
  color: #505050;
}

.result-dog-text {
  font-size: 25px;
  margin-top: 30px;
  margin-bottom: 30px;
  text-align: center;
  color: #505050;
}

.result-text {
  color: #505050;
  font-size: 1em;
  margin-bottom: 0;
  margin-top: 30px;
}

.result-textfield {
  text-align: left;
}

.result-image {
  max-width: 600px;
}

.result-headline {
  text-align: left;
  margin-left: 12px;
  color: #505050;
}

@media screen and (min-width: 600px) {
  .result-text {
    font-size: 1.4em;
  }
}
</style>