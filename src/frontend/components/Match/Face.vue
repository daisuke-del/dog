<template>
  <div class="all">
    <p class="big-text d-flex justify-center">あなたの顔はどのくらい？</p>
    <div class="face-wrap d-flex justify-center">
      <v-card hover class="face-card">
        <v-img :src="require('@/assets/faceimages/nface_image/face_image/' + faceImage)" />
      </v-card>
    </div>
    <div class="d-flex justify-center mr-8 ml-8">
      <v-slider
        max="100"
        min="0"
        v-model="face"
        thumb-color="primary"
        class="face-slider"
        background-color="blue-grey lighten-5"
      />
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
  data () {
    return {
      face: 50,
      faceImage: '99.jpeg'
    }
  },
  methods: {
    clickFace() {
      this.$emit('click-face',this.face)
    },
    clickBack () {
      this.$emit('click-back', 5)
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
  max-width: 200px;
}

.face-slider {
  margin-top: 30px;
  max-width: 500px;
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
    font-size: 2em;
  }

  .face-wrap {
    margin-top: 50px;
  }

  .face-card {
  max-width: 350px;
}

  .btn-wrap {
    margin-top: 30px;
    margin-right: 22px;
  }

  .back-btn {
    font-size: 1.2em;
    width: 120px;
    height: 36px;
  }

  .next-btn {
    font-size: 1.2em;
    width: 120px;
    height: 36px;
  }
}
</style>
