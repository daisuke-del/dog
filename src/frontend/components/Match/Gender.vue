<template>
  <div class="all">
      <p class="big-text d-flex justify-center mb-6">性別を選択してください</p>
      <div class="card-wrap">
      <v-card hover class="card" @click="clickGender('male')">
        <v-img :src="male_image" />
      </v-card>
<v-card hover class="card" @click="clickGender('female')">
        <v-img :src="female_image" />
      </v-card>
      </div>
  </div>
</template>

<script>
export default {
  name: 'MatchGender',
  data() {
    return {
      url: 'http://127.0.0.1:8000/api/',
      errored: false,
      loading: true,
      male_image: require("@/assets/faceimages/male.jpeg"),
      female_image: require("@/assets/faceimages/female.jpeg")
    }
  },
  methods: {
  }
}
</script>

<style scoped>
.all {
  height: 100%;
}

.big-text {
  font-size: 1.5em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.card-wrap {
  text-align: center;
  margin-top: 20px;
}

.card {
  display: inline-block;
  width: 35%;
  max-width: 250px;
  margin: 10px;
}

.btn-wrap {
  text-align: center;
}

.back-btn:hover {
  outline: none;
  border: 2px solid #B9C9CE;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2em;
  }

  .card {
    margin: 20px;
  }
}
</style>