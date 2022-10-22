<template>
  <div>
    <p class="big-text d-flex justify-center mb-6">どっちがイケメン？</p>
    <div class="face-wrap d-flex justify-center">
      <v-card hover class="face-card">
        <v-img src="/faceimages/nface_image/face_image/99.jpeg" />
      </v-card>
    </div>
    <div class="d-flex justify-center mr-8 ml-8">
      <v-slider
        max="100"
        min="0"
        thumb-color="primary"
        class="face-slider"
        background-color="blue-grey lighten-5"
      ></v-slider>
    </div>
    <div class="btn-wrap">
      <button class="back-btn">戻る</button>
      <button class="next-btn">次へ</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'JoinleaveFace'
}
</script>

<style scoped>
.big-text {
  font-size: 1.5em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.face-card {
  width: 35%;
  max-width: 250px;
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
  margin: 30px 0 15px 15px;
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
  margin: 30px 0 15px 15px;
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
}
</style>
