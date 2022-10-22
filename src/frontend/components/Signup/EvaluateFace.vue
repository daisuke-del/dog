<template>
  <div class="all">
    <p class="big-text d-flex justify-center">あなたの顔はどのくらい？</p>
    <div class="face-wrap d-flex justify-center">
      <v-card hover class="face-card">
        <v-img :src="require('@/assets/faceimages/nface_image/face_image/' + faceImage)" />
      </v-card>
    </div>
    <div class="d-flex justify-center">
      <v-slider
        max="100"
        min="0"
        v-model="face"
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
  data () {
    return {
      face: 50,
      faceImage: '99.jpeg'
    }
  },
  methods: {
    saveFacePoint () {
      this.$emit('store-face-point',this.face)
    },
    clickBack () {
      this.$emit('click-back', 2)
    },
    resetFace () {
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