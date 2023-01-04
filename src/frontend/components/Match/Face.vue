<template>
  <div class="all">
    <p class="big-text d-flex justify-center">あなたの顔はどのくらい？</p>
    <div class="face-wrap d-flex justify-center">
      <v-card hover class="face-card">
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[0].faceImage}`)"
          v-if="sliderValue === 0" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[1].faceImage}`)"
          v-if="sliderValue === 1" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[2].faceImage}`)"
          v-if="sliderValue === 2" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[3].faceImage}`)"
          v-if="sliderValue === 3" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[4].faceImage}`)"
          v-if="sliderValue === 4" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[5].faceImage}`)"
          v-if="sliderValue === 5" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[6].faceImage}`)"
          v-if="sliderValue === 6" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[7].faceImage}`)"
          v-if="sliderValue === 7" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[8].faceImage}`)"
          v-if="sliderValue === 8" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[9].faceImage}`)"
          v-if="sliderValue === 9" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[10].faceImage}`)"
          v-if="sliderValue === 10" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[11].faceImage}`)"
          v-if="sliderValue === 11" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[12].faceImage}`)"
          v-if="sliderValue === 12" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[13].faceImage}`)"
          v-if="sliderValue === 13" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[14].faceImage}`)"
          v-if="sliderValue === 14" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[15].faceImage}`)"
          v-if="sliderValue === 15" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[16].faceImage}`)"
          v-if="sliderValue === 16" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[17].faceImage}`)"
          v-if="sliderValue === 17" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[18].faceImage}`)"
          v-if="sliderValue === 18" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[19].faceImage}`)"
          v-if="sliderValue === 19" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[20].faceImage}`)"
          v-if="sliderValue === 20" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[21].faceImage}`)"
          v-if="sliderValue === 21" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[22].faceImage}`)"
          v-if="sliderValue === 22" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[23].faceImage}`)"
          v-if="sliderValue === 23" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[24].faceImage}`)"
          v-if="sliderValue === 24" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[25].faceImage}`)"
          v-if="sliderValue === 25" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[26].faceImage}`)"
          v-if="sliderValue === 26" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[27].faceImage}`)"
          v-if="sliderValue === 27" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[28].faceImage}`)"
          v-if="sliderValue === 28" />
        <v-img :src="require(`@/../storage/image/faceimages/${sliderFaces[29].faceImage}`)"
          v-if="sliderValue === 29" />
      </v-card>
    </div>
    <div class="d-flex justify-center mr-8 ml-8">
      <v-slider max="29" min="0" v-model="face" thumb-color="primary" class="face-slider"
        background-color="blue-grey lighten-5" />
    </div>
    <div class="btn-wrap">
      <button class="back-btn" @click="clickBack()">戻る</button>
      <button class="next-btn" @click="clickFace()">次へ</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MatchFace',
  props: {
    sliderFaces: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      face: 15,
    }
  },
  methods: {
    clickFace() {
      this.$emit('click-face', this.face)
    },
    clickBack() {
      this.$emit('click-back', 5)
    },
    resetFace() {
      this.face = 50
    }
    // getFaceSliderList() {
    //   const url = this.url + 'match/slider'
    //   axios
    //     .get(url, {
    //       timeout: 5000,
    //     })
    //     .then((response) => {
    //       console.log(response.data)
    //     })
    //     .catch(() => {
    //       this.errored = true
    //     })
    //     .finally(() => (this.loading = false))
    // },
  },
  mounted() {
    // this.getFaceSliderList()
  },
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

.face-card {
  max-width: 250px;
}

.face-slider {
  margin-top: 30px;
  max-width: 400px;
}

.btn-wrap {
  text-align: center;
  margin-right: 20px;
}

.next-btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
  background-color: white;
  width: 100px;
  height: 30px;
  border-radius: 0.3em;
  outline: 1px solid #b9c9ce;
  margin: 20px 0 15px 15px;
}

.back-btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
  background-color: white;
  width: 100px;
  height: 30px;
  border-radius: 0.3em;
  outline: 1px solid #b9c9ce;
  margin: 20px 0 15px 15px;
}

.next-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

.back-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2.3em;
  }

  .face-wrap {
    margin-top: 30px;
  }

  .face-card {
    max-width: 400px;
  }

  .next-btn,
  .back-btn {
    font-size: 1.5em;
    width: 200px;
    height: 50px;
  }
}
</style>
