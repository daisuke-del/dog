<template>
  <div class="all">
      <p class="big-text d-flex justify-center mb-6">性別を選択してください</p>
      <div class="card-wrap">
      <v-card hover class="card" @click="saveSessionGender('male')">
        <v-img :src="male_image" />
      </v-card>
<v-card hover class="card" @click="saveSessionGender('female')">
        <v-img :src="female_image" />
      </v-card>
      </div>
      <div class="btn-wrap">
        <button
            class="back-btn"
            @click="$router.back()"
        >戻る</button>
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
    // saveSessionGender(gender){
    //   const url = this.url + 'match/gender'
    //   axios.post(url, {
    //     gender: gender,
    //   }).then(response => {
    //         console.log(response.data)
    //       }
    //   )
    // }
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

.back-btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
  background-color: white;
  width: 100px;
  height: 30px;
  border-radius: .3em;
  outline: 1px solid #B9C9CE;
  margin-top: 30px;
  margin-bottom: 10px;
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