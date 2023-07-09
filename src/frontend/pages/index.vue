<template>
  <div class='all'>
    <user-dialog
      :dialog.sync="userDialog"
      :dog-info="dogInfo"
      @choice-close="choiceClose"
      @add-favorite="addFavorite"
      @delete-favorite="deleteFavorite"
    />
    <v-img
      class="logo"
      :src="require('@/assets/image/logo/logotouka.png')"
    />
    <div class='main-wrapper justify-center mt-7'>
      <div class='ranking-wrap'>
        <h3 class='ranking-headline'>人気のわんこランキング</h3>
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
            <h3 class='intro-headline'>あなたの犬種診断</h3>
            <p class='intro-text'>
              自分の性別の写真を選択して診断開始！
            </p>
            <v-row>
              <v-col cols="6">
                <v-card
                hover
                class="card"
                @click="clickGenderMale()"
              >
                  <v-img :src="require('~/assets/image/diagnosis/male2.png')" />
                </v-card>
              </v-col>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickGenderFemale()"
                >
                  <v-img :src="require('~/assets/image/diagnosis/female2.png')" />
                </v-card>
              </v-col>
            </v-row>
          </div>
          <div class='intro-small-wrap'>
            <h3 class='intro-headline'>犬種図鑑</h3>
            <v-row>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickBreed1()"
                >
                  <v-img :src='breedImage1' />
                </v-card>
                <div class="name-text mb-0">
                  <a
                    @click="clickBreed1()">
                    {{ breeds[0].name }}
                  </a>
                </div>
              </v-col>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickBreed2()"
                >
                  <v-img :src='breedImage2' />
                </v-card>
                <div class="name-text mb-0">
                  <a
                    @click="clickBreed2()">
                    {{ breeds[1].name }}
                  </a>
                </div>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickBreed3()"
                >
                  <v-img :src='breedImage3' />
                </v-card>
                <div class="name-text mb-0">
                  <a
                    @click="clickBreed3()">
                    {{ breeds[2].name }}
                  </a>
                </div>
              </v-col>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickBreed4()"
                >
                  <v-img :src='breedImage4' />
                </v-card>
                <div class="name-text mb-0">
                  <a
                    @click="clickBreed4()">
                    {{ breeds[3].name }}
                  </a>
                </div>
              </v-col>
            </v-row>
            <v-btn
              class="mt-5 all-btn"
              color="primary"
              depressed
              @click="clickAllBreed()"
            >
              全ての犬種を見る
            </v-btn>
          </div>
          <div class='intro-small-wrap'>
            <h3 class='intro-headline'>友達を探す</h3>
            <p class='intro-text'>
              友達を探しに行こう！<br>みんなのSNSも見られるよ！
            </p>
            <v-row>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickUser(users[0])"
                >
                  <v-img :src='userImage1' />
                </v-card>
                <div class="name-text mb-0">
                  <a
                    @click="clickUser(users[0])">
                    {{ users[0].name }}
                  </a>
                </div>
              </v-col>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickUser(users[1])"
                >
                  <v-img :src='userImage2' />
                </v-card>
                <div class="name-text mb-0">
                  <a
                    @click="clickUser(users[1])">
                    {{ users[1].name }}
                  </a>
                </div>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickUser(users[2])"
                >
                  <v-img :src='userImage3' />
                </v-card>
                <div class="name-text mb-0">
                  <a
                    @click="clickUser(users[2])">
                    {{ users[2].name }}
                  </a>
                </div>
              </v-col>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickUser(users[3])"
                >
                  <v-img :src='userImage4' />
                </v-card>
                <div class="name-text mb-0">
                  <a
                    @click="clickUser(users[3])">
                    {{ users[3].name }}
                  </a>
                </div>
              </v-col>
            </v-row>
            <v-btn
              class="mt-5 all-btn"
              color="primary"
              depressed
              @click="clickAllUsers()"
            >
              もっと見る
            </v-btn>
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
import UserDialog from '@/components/Common/UserDialog'
import ranking from '@/plugins/modules/ranking'
import breed from '@/plugins/modules/breed'
import user from '@/plugins/modules/user'
import favorite from '@/plugins/modules/favorite'

export default {
  components: { UserDialog },
  auth: false,
  async asyncData({ app }) {
    let dogRanking = []
    let users = []
    if (app.store.$auth.loggedIn) {
      await user.getUserInfo().then((response) => {
          app.store.dispatch('authInfo/setAuthInfo', response)
      })
      await ranking.getRankingWithFriends().then((response) => {
        dogRanking = response
      })
      await user.getUsersRandomWithFriends().then((response) => {
          users = response
      })
    } else {
      await ranking.getRanking().then((response) => {
        dogRanking = response
      })
      await user.getUsersRandom().then((response) => {
          users = response
      })
    }
    let breeds = []
    await breed.getBreedsRandom().then((response) => {
        breeds = response
    })
    return {
      dogRanking,
      breeds,
      users
    }
  },
  data () {
    return {
      dogRanking: [],
      users: [],
      userDialog: false,
      dialogIndex: 0,
      dogInfo: {
        name: 'バニラ',
        birthday: '2022年1月3日',
        dog_image1: '4.jpg',
        dog_image2: '1.jpg',
        dog_image3: '3.jpg',
        comment: 'バニラ',
        twitter_id: '',
        instagram_id: '',
        tiktok_id: '',
        blog_id: ''
      },
      pages: null
    }
  },
  computed: {
    firstDog () {
      return this.dogRanking[0].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[0].dog_image1}`
    },
    secondDog () {
      return this.dogRanking[1].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[1].dog_image1}`
    },
    thirdDog () {
      return this.dogRanking[2].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[2].dog_image1}`
    },
    fourthDog () {
      return this.dogRanking[3].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[3].dog_image1}`
    },
    fifthDog () {
      return this.dogRanking[4].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[4].dog_image1}`
    },
    sixthDog () {
      return this.dogRanking[5].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[5].dog_image1}`
    },
    seventhDog () {
      return this.dogRanking[6].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[6].dog_image1}`
    },
    eighthDog () {
      return this.dogRanking[7].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[7].dog_image1}`
    },
    ninethDog () {
      return this.dogRanking[8].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[8].dog_image1}`
    },
    tenthDog () {
      return this.dogRanking[9].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[9].dog_image1}`
    },
    eleventhDog () {
      return this.dogRanking[10].dog_image1 && `http://dogiland.jp/storage/${this.dogRanking[10].dog_image1}`
    },
    breedImage1 () {
      return this.breeds[0].dog_image && require(`@/assets/image/breed/${this.breeds[0].dog_image}`)
    },
    breedImage2 () {
      return this.breeds[1].dog_image && require(`@/assets/image/breed/${this.breeds[1].dog_image}`)
    },
    breedImage3 () {
      return this.breeds[2].dog_image && require(`@/assets/image/breed/${this.breeds[2].dog_image}`)
    },
    breedImage4 () {
      return this.breeds[3].dog_image && require(`@/assets/image/breed/${this.breeds[3].dog_image}`)
    },
    userImage1 () {
      return this.users[0].dog_image1 && `http://dogiland.jp/storage/${this.users[0].dog_image1}`
    },
    userImage2 () {
      return this.users[1].dog_image1 && `http://dogiland.jp/storage/${this.users[1].dog_image1}`
    },
    userImage3 () {
      return this.users[2].dog_image1 && `http://dogiland.jp/storage/${this.users[2].dog_image1}`
    },
    userImage4 () {
      return this.users[3].dog_image1 && `http://dogiland.jp/storage/${this.users[3].dog_image1}`
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
      this.pages = 'ranking'
      this.dogInfo = this.dogRanking[index]
      this.userDialog = true
    },
    choiceClose () {
      this.userDialog = false
    },
    clickAllBreed () {
      this.$router.push('/breed');
    },
    clickBreed1 () {
      const breed1 = this.breeds[0].dog_image.replace(".png", "")
      this.$router.push(`/breed/detail/${breed1}`);
    },
    clickBreed2 () {
      const breed2 = this.breeds[1].dog_image.replace(".png", "")
      this.$router.push(`/breed/detail/${breed2}`);
    },
    clickBreed3 () {
      const breed3 = this.breeds[2].dog_image.replace(".png", "")
      this.$router.push(`/breed/detail/${breed3}`);
    },
    clickBreed4 () {
      const breed4 = this.breeds[3].dog_image.replace(".png", "")
      this.$router.push(`/breed/detail/${breed4}`);
    },
    clickGenderMale () {
      this.$router.push({ path: '/diagnosis', query: { gender: 'male' } });
    },
    clickGenderFemale () {
      this.$router.push({ path: '/diagnosis', query: { gender: 'female' } });
    },
    clickUser (user) {
      this.pages = 'users'
      this.userDialog = true
      this.dogInfo = user
    },
    clickAllUsers () {
      this.$router.push('/dog');
    },
    addFavorite(friendId) {
      if (!this.$auth.loggedIn) {
        this.$router.push('/login')
      } else {
        favorite.addFavorite(friendId).then((response) => {
          if (this.pages === 'users') {
            this.findUserById(this.users, friendId, response)
          } else if (this.pages === 'ranking') {
            this.findUserById(this.dogRanking, friendId, response)
          }
        })
      }
    },
    deleteFavorite(friendId) {
      if (!this.$auth.loggedIn) {
        this.$router.push('/login')
      } else {
        favorite.deleteFavorite(friendId).then((response) => {
          if (this.pages === 'users') {
            this.findUserById(this.users, friendId, response)
          } else if (this.pages === 'ranking') {
            this.findUserById(this.dogRanking, friendId, response)
          }
        })
      }
    },
    findUserById(users, userId, response) {
      for (var i = 0; i < users.length; i++) {
        if (users[i].user_id === userId) {
          users[i] = response
          this.dogInfo = response
        }
      }
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
  margin-top: 40px !important;
}

.logo {
  max-width: 500px;
  margin: 0 auto;
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
  max-width: 30px;
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
  background-color: #97B6B8;
}

.blue-btn {
  background-color: #97B6B8;
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

.all-btn {
  font-weight: bold;
}

.name-text {
    text-align: left;
}

.name-text a {
    color: slategray;
    font-family: 'Noto Sans JP', sans-serif;
    font-size: 12px;
    font-weight: bold;
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
