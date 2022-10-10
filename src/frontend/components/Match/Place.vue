<template>
  <div class="all">
    <p class="big-text d-flex justify-center">出会う方法を選択してください</p>
    <v-row class="place-wrap">
      <v-col
        v-for="match in matches"
        :key="match.name"
        cols="6"
        sm="4"
        class="place-box"
      >
        <v-card 
          class="place-card"
          @click="clickPlace(match.name)"
        >
          <v-img :src="match.img" />
        </v-card>
      </v-col>
    </v-row>
    <div class="btn-wrap">
      <button class="back-btn" @click="clickBack()">戻る</button>
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
      place: null
    }
  },
  methods: {
    clickPlace (place) {
      this.place = place
      this.$emit('click-place', this.place) 
    },
    clickBack () {
      this.$emit('click-back', 6)
    },
    resetPlace () {
      this.place = null
    }
  }
}
</script>

<style scoped>
.all {
  margin-right:30px ;
}

.big-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.place-wrap {
  text-align: center;
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
}

.place-box {
  text-align: center;
  align-items: center;
}

.place-card {
  margin: 10px;
  max-width: 200px;
  max-height: 200px;
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

  .place-wrap {
    margin-top: 50px;
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
}
</style>
