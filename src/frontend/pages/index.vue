<template>
  <div class="all">
    <div class="main-wrapper justify-center">
      <div class="top-text-wrap">
        <v-img
          :src="require('@/assets/image/logo/logotouka.png')"
        />
      </div>
      <div class="ranking-wrap">
        <h2 class="ranking-headline">【男性】人気の顔ランキング</h2>
        <v-row>
          <v-col cols="4" class="ranking-col">
            <v-img
              :src="require('@/assets/image/rank/1st.png')"
              class="ranking-icon"
            />
            <v-card>
              <v-img
                :src="firstMale"
              />
            </v-card>
          </v-col>
          <v-col cols="4" class="ranking-col">
            <v-img
              :src="require('@/assets/image/rank/2nd.png')"
              class="ranking-icon"
            />
            <v-card>
              <v-img
                :src="secondMale"
              />
            </v-card>
          </v-col>
          <v-col cols="4" class="ranking-col">
            <v-img
              :src="require('@/assets/image/rank/3rd.png')"
              class="ranking-icon"
            />
            <v-card>
              <v-img
                :src="thirdMale"
              />
            </v-card>
          </v-col>
        </v-row>
      </div>
      <div class="ranking-wrap">
        <h2 class="ranking-headline">【女性】人気の顔ランキング</h2>
        <v-row>
          <v-col cols="4" class="ranking-col">
            <v-img
              :src="require('@/assets/image/rank/1st.png')"
              class="ranking-icon"
            />
            <v-card>
              <v-img
                :src="firstFemale"
              />
            </v-card>
          </v-col>
          <v-col cols="4" class="ranking-col">
            <v-img
              :src="require('@/assets/image/rank/2nd.png')"
              class="ranking-icon"
            />
            <v-card>
              <v-img
                :src="secondFemale"
              />
            </v-card>
          </v-col>
          <v-col cols="4" class="ranking-col">
            <v-img
              :src="require('@/assets/image/rank/3rd.png')"
              class="ranking-icon"
            />
            <v-card>
              <v-img
                :src="thirdFemale"
              />
            </v-card>
          </v-col>
        </v-row>
      </div>
      <div class="btn-wrap">
        <a class="btn-text" @click="clickSignup">無料登録して始める</a>
      </div>
      <div class="intro-wrap">
        <div class="intro-small-wrap">
          <h3 class="intro-headline">完全無料</h3>
          <p class="intro-text">
            課金は必要なし！
          </p>
        </div>
        <div class="intro-small-wrap">
          <h3 class="intro-headline">無料パートナー診断</h3>
          <p class="intro-text">
            今の自分のレベルに合った相手を診断
          </p>
        </div>
        <div class="intro-small-wrap">
          <h3 class="intro-headline">放置するだけ</h3>
          <p class="intro-text">
            顔写真を登録して放置するだけで<br>リアルタイムに自分の顔レベルを測定できる！
          </p>
        </div>
        <div class="intro-small-wrap">
          <h3 class="intro-headline">フレンド機能</h3>
          <p class="intro-text">
            気になった相手にはいいねをしよう！<br>意気投合したらお互いのSNSを閲覧可能に
          </p>
        </div>
      </div>
      <div class="btn-wrap">
        <a class="btn-text" @click="clickMatch">パートナー診断を開始</a>
      </div>
    </div>
  </div>
</template>

<script>
import ranking from '@/plugins/modules/ranking'
export default {
  name: 'TopPage',
  auth: false,
  async asyncData() {
    let maleRanking = []
    let femaleRanking = []
    await ranking.getRanking().then((response) => {
      maleRanking = response['male']
      femaleRanking = response['female']
    })
    return {
      maleRanking,
      femaleRanking
    }
  },
  data() {
    return {
      maleRanking: [
        {face_image: 'm1.jpeg'},
        {face_image: 'm2.jpeg'},
        {face_image: 'm3.jpeg'}
      ],
      femaleRanking: [
        {face_image: '1.jpeg'},
        {face_image: '2.jpeg'},
        {face_image: '3.jpeg'}
      ]
    }
  },
  computed: {
    firstMale () {
      return this.maleRanking[0].face_image && require(`@/../storage/image/faceimages/${this.maleRanking[0].face_image}`)
    },
    secondMale () {
      return this.maleRanking[1].face_image && require(`@/../storage/image/faceimages/${this.maleRanking[1].face_image}`)
    },
    thirdMale () {
      return this.maleRanking[2].face_image && require(`@/../storage/image/faceimages/${this.maleRanking[2].face_image}`)
    },
    firstFemale () {
      return this.maleRanking[0].face_image && require(`@/../storage/image/faceimages/${this.femaleRanking[0].face_image}`)
    },
    secondFemale () {
      return this.maleRanking[1].face_image && require(`@/../storage/image/faceimages/${this.femaleRanking[1].face_image}`)
    },
    thirdFemale () {
      return this.maleRanking[2].face_image && require(`@/../storage/image/faceimages/${this.femaleRanking[2].face_image}`)
    }
  },
  methods: {
    clickSignup() {
      this.$router.push('signup')
    },
    clickMatch() {
      this.$router.push('match')
    }
  }
}
</script>
<style scoped>
a {
  text-decoration: none;
}

h2 {
  font-family: 'Noto Sans JP', sans-serif;
  color: dimgrey;

}

h3 {
  font-family: 'Rampart One', cursive;
}

.all {
  padding: 20px;
  min-width: 350px;
  max-width: 600px;
  margin: 0 auto;
}

.main-wrapper {
  margin: 0 auto;
  max-width: 1080px;
}

.ranking-col {
  position: relative;
}

.ranking-headline {
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: left;
  font-size: 17px;
}

.ranking-icon {
  z-index: 2;
  position: absolute;
  top: 1%;
  left: -3%;
  max-width: 35px;
}

.top-text-wrap {
  max-width: 500px;
  width: 50%;
  margin: 0 auto;
}

.top-text {
  padding-right: 20%;
  padding-left: 20%;
}

.btn-wrap {
  text-align: center;
  margin-top: 20px;
  margin-bottom: 20px;
}

.btn-text {
  border-radius: 30px;
  background-color: #f57ab1;
  color: white;
  padding: 15px;
  display: inline-block;
  font-size: 15px;
  font-weight: bolder;
  width: 75%;
  max-width: 400px;
  min-width: 200px;
}

.intro-wrap {
  text-align: center;
  max-width: 300px;
  margin: 0 auto;
}

.intro-headline {
  font-size: 25px;
  margin-top: 10px;
  margin-bottom: 10px;
  text-align: left;
  color: black;
  text-decoration: underline; /* 下線 */
  text-decoration-thickness: 0.5em; /* 線の太さ */
  text-decoration-color: rgba(255, 228, 0, 0.4); /* 線の色 */
  text-underline-offset: -0.2em; /* 線の位置。テキストに重なるようにやや上部にする */
  text-decoration-skip-ink: none;

}

.intro-text {
  text-align: left;
  font-size: 15px;
  color: black;
  padding: 30px 0;
}

@media screen and (min-width: 600px) {
  .intro-wrap {
    max-width: 400px;
  }

  .ranking-icon {
    max-width: 50px;
  }
}

@media screen and (min-width: 750px) {
  .btn-text {
    border-radius: 50px;
    padding: 20px;
    display: inline-block;
    font-size: 20px;
  }

  .intro-headline {
    font-size: 30px;
  }

  .intro-text {
    font-size: 20px;
  }
}
</style>
