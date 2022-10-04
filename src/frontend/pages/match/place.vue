<template>
  <div>
    <p class="big-text d-flex justify-center">出会う方法を選択してください</p>
    <v-row class="place-wrap">
      <v-col
        v-for="match in matches"
        :key="match.name"
        cols="6"
        sm="4"
        class="place-box"
      >
        <v-card class="place-card">
          <v-img :src="match.img" />
        </v-card>
      </v-col>
    </v-row>
    <div class="btn-wrap">
      <button class="back-btn" @click="$router.back()">戻る</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MatchPlace',
  data() {
    return {
      model: null,
      matches: [
        { name: 'club', img: require('@/assets/match/club.jpeg') },
        { name: 'introduction', img: require('@/assets/match/introduction.jpeg') },
        { name: 'jointparty', img: require('@/assets/match/jointparty.jpeg') },
        { name: 'pairs', img: require('@/assets/match/pairs.jpeg') },
        { name: 'tinder', img: require('@/assets/match/tinder.jpeg') },
        { name: 'workplace', img: require('@/assets/match/workplace.jpeg') },
      ],
    }
  },
}
</script>

<style scoped>
.big-text {
  font-size: 1.5em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.place-wrap {
  margin: 50px 50px 30px 30px;
}

.place-box {
  text-align: center;
  align-items: center;
}

.place-card {
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
  border-radius: 0.3em;
  outline: 1px solid #b9c9ce;
  margin-top: 30px;
  margin-bottom: 10px;
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

@media screen and (min-width: 900px) {
  .place-card {
    margin: 30px;
  }
}
</style>
