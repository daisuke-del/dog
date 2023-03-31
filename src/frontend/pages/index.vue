<template>
  <div class="all">
    <div class="main-wrapper justify-center">
      <div class="top-text-wrap">
        <v-img
          :src="require('@/assets/image/logo/logotouka.png')"
        />
      </div>
      <div class="ranking-wrap">
        <h2 class="ranking-headline">人気のわんこランキング</h2>
        <v-row>
          <v-col cols="4" class="ranking-col">
            <v-img
              :src="require('@/assets/image/rank/1st.png')"
              class="ranking-icon"
            />
            <v-card>
              <v-img
                :src="firstDog"
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
                :src="secondDog"
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
                :src="thirdDog"
              />
            </v-card>
          </v-col>
        </v-row>
      </div>
      <div class="btn-wrap">
        <a class="btn-text pink-btn" @click="clickSignup">無料登録して始める</a>
      </div>
      <div class="how-to-wrap">
        <v-img
          :src="require('@/assets/image/other/how-to-use.png')"
          class="how-to-image"
        />
      </div>
      <div class="intro-wrap">
        <div class="intro-text-wrap">
          <div class="intro-small-wrap">
            <h3 class="intro-headline">完全無料</h3>
            <p class="intro-text">
              課金は必要なし！
            </p>
          </div>
          <div class="intro-small-wrap">
            <h3 class="intro-headline">わんこ診断</h3>
            <p class="intro-text">
              あなたの性格や体格から診断！
            </p>
          </div>
          <div class="btn-wrap">
            <a class="btn-text blue-btn" @click="clickDiagnosis">わんこ診断を開始</a>
          </div>
          <div class="intro-small-wrap">
            <h3 class="intro-headline">フレンド機能</h3>
            <p class="intro-text">
              気になったわんこにいいねをしよう！<br>意気投合したらお互いのSNSを閲覧可能に
            </p>
          </div>
          <div class="intro-small-wrap">
            <h3 class="intro-headline">人気ランキング</h3>
            <p class="intro-text">
              人気ランキング上位を狙おう！<br>上位にランクインするとトップページに掲載
            </p>
          </div>
          <div class="btn-wrap">
            <a class="btn-text pink-btn" @click="clickSignup">無料登録してランクイン！</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ranking from '@/plugins/modules/ranking'
export default {
  auth: false,
  async asyncData() {
    let dogRanking = []
    await ranking.getRanking().then((response) => {
      dogRanking = response['dogs']
    })
    return {
      dogRanking
    }
  },
  computed: {
    firstDog () {
      return this.maleRanking[0].dog_image && `http://localhost/storage/${this.maleRanking[0].dog_image}`
    },
    secondDog () {
      return this.maleRanking[1].dog_image && `http://localhost/storage/${this.maleRanking[1].dog_image}`
    },
    thirdDog () {
      return this.maleRanking[2].dog_image && `http://localhost/storage/${this.maleRanking[2].dog_image}`
    }
  },
  methods: {
    clickSignup() {
      this.$router.push('signup')
    },
    clickDiagnosis() {
      this.$router.push('diagnosis')
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
  min-width: 350px;
}

.top-text-wrap {
  max-width: 400px;
  width: 50%;
  margin: 0 auto;
  padding-top: 20px;
  padding-bottom: 20px;
}

.ranking-col {
  position: relative;
}

.ranking-wrap {
  margin: 0 20px;
}

.ranking-headline {
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: left;
  font-size: 15px;
}

.ranking-icon {
  z-index: 2;
  position: absolute;
  top: 1%;
  left: -3%;
  max-width: 35px;
}

.top-text {
  padding-right: 20%;
  padding-left: 20%;
}

.btn-wrap {
  text-align: center;
  margin-top: 30px;
  margin-bottom: 30px;
}

.btn-text {
  border-radius: 30px;
  color: white;
  padding: 15px;
  display: inline-block;
  font-size: 15px;
  font-weight: bolder;
  width: 75%;
  max-width: 400px;
  min-width: 200px;
}

.pink-btn {
  background-color: #f57ab1;
}

.blue-btn {
  background-color: #5383c3;
}

.how-to-wrap {
  padding-top: 30px;
  padding-bottom: 30px;
  width: 100%;
  background-color: #fffdf3;
}

.intro-wrap {
  text-align: center;
  width: 100%;
  padding-bottom: 50px
}

.intro-text-wrap {
  max-width: 300px;
  margin: 0 auto;
}

.intro-headline {
  font-size: 25px;
  margin-top: 20px;
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
  padding: 10px 0;
  margin-bottom: 0;
}
@media screen and (min-width: 600px) {
  .top-text-wrap {
  padding-top: 30px;
  padding-bottom: 30px;
}

  .ranking-wrap {
    max-width: 600px;
    margin: 0 auto;
  }

  .ranking-headline {
    font-size: 25px;
  }

  .ranking-icon {
    max-width: 50px;
  }

  .intro-headline {
    font-size: 30px;
    margin-top: 30px;
  }

  .intro-text-wrap {
    max-width: 450px;
  }

  .intro-text {
    font-size: 20px;
    letter-spacing: 5px;
  }

  .how-to-wrap {
    padding-top: 50px;
    padding-bottom: 50px;
    width: 100%;
    background-color: #fffdf3;
  }

  .how-to-image {
    max-width: 800px;
    margin: 0 auto;
  }
}
</style>
