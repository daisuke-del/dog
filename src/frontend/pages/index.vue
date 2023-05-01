<template>
  <div class='all'>
    <ranking-dialog
      :dialog.sync="rankingDialog"
      :dog-info="dogRanking[dialogIndex]"
      @choice-close="choiceClose"
  />
    <div class='main-wrapper justify-center'>
      <div class='top-text-wrap'>
        <v-img
          :src="require('@/assets/image/logo/logotouka.png')"
        />
      </div>
      <div class='ranking-wrap'>
        <h2 class='ranking-headline'>人気のわんこランキング</h2>
        <v-row>
          <v-col cols='4' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/1st.png')"
              class='ranking-icon-crown'
            />
            <v-card>
              <v-img
                :src='firstDog'
                @click='clickImage(0)'
              />
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/2nd.png')"
              class='ranking-icon-crown'
            />
            <v-card>
              <v-img
                :src='secondDog'
                @click='clickImage(1)'
              />
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/3rd.png')"
              class='ranking-icon-crown'
            />
            <v-card>
              <v-img
                :src='thirdDog'
                @click='clickImage(2)'
              />
            </v-card>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols='3' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/4th.png')"
              class='ranking-icon'
            />
            <v-card>
              <v-img
                :src='fourthDog'
                @click='clickImage(3)'
              />
            </v-card>
          </v-col>
          <v-col cols='3' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/5th.png')"
              class='ranking-icon'
            />
            <v-card>
              <v-img
                :src='fifthDog'
                @click='clickImage(4)'
              />
            </v-card>
          </v-col>
          <v-col cols='3' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/6th.png')"
              class='ranking-icon'
            />
            <v-card>
              <v-img
                :src='sixthDog'
                @click='clickImage(5)'
              />
            </v-card>
          </v-col>
          <v-col cols='3' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/7th.png')"
              class='ranking-icon'
            />
            <v-card>
              <v-img
                :src='seventhDog'
                @click='clickImage(6)'
              />
            </v-card>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols='3' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/8th.png')"
              class='ranking-icon'
            />
            <v-card>
              <v-img
                :src='eighthDog'
                @click='clickImage(7)'
              />
            </v-card>
          </v-col>
          <v-col cols='3' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/9th.png')"
              class='ranking-icon'
            />
            <v-card>
              <v-img
                :src='ninethDog'
                @click='clickImage(8)'
              />
            </v-card>
          </v-col>
          <v-col cols='3' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/10th.png')"
              class='ranking-icon'
            />
            <v-card>
              <v-img
                :src='tenthDog'
                @click='clickImage(9)'
              />
            </v-card>
          </v-col>
          <v-col cols='3' class='ranking-col'>
            <v-img
              :src="require('@/assets/image/rank/11th.png')"
              class='ranking-icon'
            />
            <v-card>
              <v-img
                :src='eleventhDog'
                @click='clickImage(10)'
              />
            </v-card>
          </v-col>
        </v-row>
      </div>
      <div class='btn-wrap'>
        <a class='btn-text blue-btn' @click='clickDiagnosis'>あなたの犬種診断を開始</a>
      </div>
      <div class='intro-wrap'>
        <div class='intro-text-wrap'>
          <div class='intro-small-wrap'>
            <h3 class='intro-headline'>完全無料</h3>
            <p class='intro-text'>
              課金は必要なし！
            </p>
          </div>
          <div class='intro-small-wrap'>
            <h3 class='intro-headline'>あなたの犬種診断</h3>
            <p class='intro-text'>
              自分が犬だったらどんな犬種だろう？
            </p>
          </div>
          <div class='intro-small-wrap'>
            <h3 class='intro-headline'>フレンド機能</h3>
            <p class='intro-text'>
              気になったわんこにいいねを送ろう！<br>意気投合したらお互いのSNSを閲覧可能に
            </p>
          </div>
          <div class='intro-small-wrap'>
            <h3 class='intro-headline'>人気ランキング</h3>
            <p class='intro-text'>
              人気ランキング上位を狙おう！<br>上位にランクインするとトップページに掲載
            </p>
          </div>
          <div class='btn-wrap'>
            <a class='btn-text pink-btn' @click='clickSignup'>無料登録して始める</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import RankingDialog from '@/components/Top/RankingDialog'
import ranking from '@/plugins/modules/ranking'
export default {
  components: { RankingDialog },
  auth: false,
  async asyncData() {
    let dogRanking = []
    await ranking.getRanking().then((response) => {
      dogRanking = response
    })
    return {
      dogRanking
    }
  },
  data () {
    return {
      dogRanking: [],
      rankingDialog: false,
      dialogIndex: 0,
    }
  },
  computed: {
    firstDog () {
      return this.dogRanking[0].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[0].dog_image1}`)
    },
    secondDog () {
      return this.dogRanking[1].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[1].dog_image1}`)
    },
    thirdDog () {
      return this.dogRanking[2].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[2].dog_image1}`)
    },
    fourthDog () {
      return this.dogRanking[3].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[3].dog_image1}`)
    },
    fifthDog () {
      return this.dogRanking[4].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[4].dog_image1}`)
    },
    sixthDog () {
      return this.dogRanking[5].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[5].dog_image1}`)
    },
    seventhDog () {
      return this.dogRanking[6].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[6].dog_image1}`)
    },
    eighthDog () {
      return this.dogRanking[7].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[7].dog_image1}`)
    },
    ninethDog () {
      return this.dogRanking[8].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[8].dog_image1}`)
    },
    tenthDog () {
      return this.dogRanking[9].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[9].dog_image1}`)
    },
    eleventhDog () {
      return this.dogRanking[10].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[10].dog_image1}`)
    }
  },
  methods: {
    clickSignup () {
      this.$router.push('signup')
    },
    clickDiagnosis () {
      this.$router.push('diagnosis')
    },
    clickImage (index) {
      this.dialogIndex = index
      this.rankingDialog = true
    },
    choiceClose () {
      this.rankingDialog = false
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
  left: 0;
  max-width: 20px;
}

.ranking-icon-crown {
  z-index: 2;
  position: absolute;
  top: 1%;
  left: -3%;
  max-width: 35px;
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
  background-color: #5383c3;
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
  text-decoration: underline;
  text-decoration-thickness: 0.5em;
  text-decoration-color: rgba(255, 228, 0, 0.4);
  text-underline-offset: -0.2em;
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
    max-width: 30px;
  }

  .ranking-icon-crown {
    max-width: 60px;
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
