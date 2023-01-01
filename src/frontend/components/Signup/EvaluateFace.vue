<template>
  <div class="all">
    <p class="big-text d-flex justify-center">あなたの顔はどのくらい？</p>
    <div class="face-wrap d-flex justify-center">
      <v-card hover class="face-card">
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[0].faceImage}`)"
          v-if="sliderValue === 0" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[1].faceImage}`)"
          v-if="sliderValue === 1" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[2].faceImage}`)"
          v-if="sliderValue === 2" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[3].faceImage}`)"
          v-if="sliderValue === 3" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[4].faceImage}`)"
          v-if="sliderValue === 4" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[5].faceImage}`)"
          v-if="sliderValue === 5" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[6].faceImage}`)"
          v-if="sliderValue === 6" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[7].faceImage}`)"
          v-if="sliderValue === 7" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[8].faceImage}`)"
          v-if="sliderValue === 8" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[9].faceImage}`)"
          v-if="sliderValue === 9" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[10].faceImage}`)"
          v-if="sliderValue === 10" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[11].faceImage}`)"
          v-if="sliderValue === 11" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[12].faceImage}`)"
          v-if="sliderValue === 12" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[13].faceImage}`)"
          v-if="sliderValue === 13" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[14].faceImage}`)"
          v-if="sliderValue === 14" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[15].faceImage}`)"
          v-if="sliderValue === 15" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[16].faceImage}`)"
          v-if="sliderValue === 16" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[17].faceImage}`)"
          v-if="sliderValue === 17" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[18].faceImage}`)"
          v-if="sliderValue === 18" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[19].faceImage}`)"
          v-if="sliderValue === 19" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[20].faceImage}`)"
          v-if="sliderValue === 20" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[21].faceImage}`)"
          v-if="sliderValue === 21" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[22].faceImage}`)"
          v-if="sliderValue === 22" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[23].faceImage}`)"
          v-if="sliderValue === 23" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[24].faceImage}`)"
          v-if="sliderValue === 24" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[25].faceImage}`)"
          v-if="sliderValue === 25" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[26].faceImage}`)"
          v-if="sliderValue === 26" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[27].faceImage}`)"
          v-if="sliderValue === 27" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[28].faceImage}`)"
          v-if="sliderValue === 28" />
        <v-img :src="require(`/storage/image/faceimages/mface_image/${sliderFaces[29].faceImage}`)"
          v-if="sliderValue === 29" />
      </v-card>
    </div>
    <div class="d-flex justify-center">
      <v-slider
        max="29"
        min="0"
        v-model="sliderValue"
        thumb-color="primary"
        hide-details
        class="face-slider"
        background-color="blue-grey lighten-5"
      />
    </div>
    <div class="btn-wrap">
      <v-btn
        block
        depressed
        color="primary"
        height="50px"
        class="btn"
        @click="saveFacePoint"
      >
        次へ
      </v-btn>
      <v-btn
        block
        depressed
        color="#c4c4c4"
        height="50px"
        class="btn mt-3"
        @click="clickBack()"
      >
        戻る
      </v-btn>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MatchFace',
  props: {
    sliderFaces: {
      type: Array,
      require: true
    }
  },
  data () {
    return {
      sliderValue: 15
    }
  },
  methods: {
    saveFacePoint () {
      this.$emit('store-face-point',this.sliderValue)
    },
    clickBack () {
      this.$emit('click-back', 2)
    },
    resetFace () {
      this.face = 15
    }
  }
}
</script>

<style scoped>
.big-text {
  font-size: 1.3em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.face-card {
  max-width: 300px;
}

.face-slider {
  margin: 30px 0;
  max-width: 300px;
}

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

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2em;
  }

  .face-wrap {
    margin-top: 50px;
  }

  .face-card {
    max-width: 350px;
  }

  .face-slider {
    max-width: 350px;
  }

  .btn-wrap {
    width: 350px;
  }
}
</style>
