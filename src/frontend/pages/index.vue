<template>
  <div class='all pb-12'>
    <user-dialog
      :dialog.sync="userDialog"
      :dog-info="dogInfo"
      @choice-close="choiceClose"
      @add-favorite="addFavorite"
      @delete-favorite="deleteFavorite"
    />
    <v-card
      flat
      tile
      class="pt-2 banner-wrap"
    >
      <v-window
        v-model="onboarding"
        show-arrows
        class="banner"
      >
        <template v-slot:prev>
          <v-btn
            icon
            class="custom-arrow"
            @click="clickLeft"
          >
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </template>
        <template v-slot:next>
          <v-btn
            icon
            class="custom-arrow"
            @click="clickRight"
          >
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </template>
        <v-window-item
          v-for="n in length"
          :key="n.index"
          eager
        >
          <v-img
            v-if="dogRanking.length > n"
            :src="getImageUrl(`${dogRanking[n - 1].dog_image1}`)"
            class=" ml-8 mr-8"
            eager
          />
        </v-window-item>
      </v-window>

      <v-card-actions class="d-flex justify-center">
        <v-item-group
          v-model="onboarding"
          class="text-center"
          mandatory
        >
          <v-item
            v-for="n in length"
            :key="`btn-${n}`"
            v-slot="{ active }"
          >
            <v-icon
              dense
              small
              disable
              :color="active ? 'primary' : '#F1F1F1'"
              style="font-size: 16px;"
              class="pa-1"
            >
              mdi-record
            </v-icon>
          </v-item>
        </v-item-group>
      </v-card-actions>
    </v-card>
    <v-row class="text-wrap mt-2">
      <v-col cols="auto" class="text">
        <p class="mb-0">
          ドッグアイランドは
        </p>
        <p class="mb-0">
          <span class="text-liner"><span class="big-text">わんこ</span>が<span class="big-text">大好き</span></span>な
        </p>
        <p class="mb-0">
          みんなのための
        </p>
        <p class="mb-0">
          ソーシャルメディアです
        </p>
      </v-col>
    </v-row>
    <div v-if="$store.$auth.loggedIn" class='btn-wrap ml-4 mr-4'>
      <a class='btn-text blue-btn' @click="clickAllUsers()">
        わんこのお友達を探す<v-icon color="white" class="btn-icon">mdi-chevron-right</v-icon>
      </a>
    </div>
    <div v-else class='btn-wrap ml-4 mr-4'>
      <a class='btn-text blue-btn' @click='clickSignup()'>
        今すぐ登録して始める<v-icon color="white" class="btn-icon">mdi-chevron-right</v-icon>
      </a>
    </div>
    <div class='mt-10 pl-4 pr-4 main-wrap'>
      <div class="text mb-8">
        <p class="mb-0 text-center">
          ドッグアイランドで
        </p>
        <p class="mb-0 text-center">
          できること
        </p>
      </div>
      <div>
        <h3 class="headline-dog">
          <PawsIcon class="paws-icon headline-text" />
          <span class="headline-text">人気のわんこランキング</span>
        </h3>
        <p class="intro-text">
          いいねして上位を目指そう！
        </p>

        <v-row v-if="dogRanking.length > 0" align="end" class="ranking-line">
          <v-col
            v-for="(dog, index) in dogRanking.slice(0, 3)"
            :key="index"
            cols="4"
            class="ranking-col"
          >
            <component
              :is="getRankComponent(index)"
              class="ranking-icon"
            />
            <v-card>
              <v-img
                :src="getImageUrl(dog.dog_image1)"
                @click="clickImage(index)"
              />
            </v-card>
          </v-col>
        </v-row>

        <v-row class="ranking-line">
          <v-col
            v-for="(dog, index) in dogRanking.slice(3, 7)"
            :key="index + 3"
            cols="3"
            class="ranking-col"
          >
            <v-card>
              <v-img
                :src="getImageUrl(dog.dog_image1)"
                @click="clickImage(index + 3)"
              />
            </v-card>
          </v-col>
        </v-row>

        <v-row v-if="dogRanking.length > 0" class="ranking-line">
          <v-col
            v-for="(dog, index) in dogRanking.slice(7, 11)"
            :key="index + 7"
            cols="3"
            class="ranking-col"
          >
            <v-card>
              <v-img
                :src="getImageUrl(dog.dog_image1)"
                @click="clickImage(index + 7)"
              />
            </v-card>
          </v-col>
        </v-row>
      </div>
      <div
        v-if="$store.$auth.loggedIn"
        class='btn-wrap mt-5'
      >
        <a
          class='btn-text blue-btn'
          @click="clickAllUsers()"
        >
          わんこのお友達を探す<v-icon color="white" class="btn-icon">mdi-chevron-right</v-icon>
        </a>
      </div>
      <div
        v-else
        class='btn-wrap mt-5'
      >
        <a
          class='btn-text blue-btn'
          @click='clickSignup()'
        >
          今すぐ登録して始める<v-icon color="white" class="btn-icon">mdi-chevron-right</v-icon>
        </a>
      </div>
      <div
        v-if="!$store.$auth.loggedIn"
        class="text-center mt-5 mb-12"
      >
        <a
          class="btn-under-text"
          @click="clickLogin()"
        >
          アカウントをお持ちの方はこちら
        </a>
      </div>
      <div class='intro-wrap mt-8'>
        <div class='intro-text-wrap'>
          <div>
            <h3 class='headline-dog'>
              <PawsIcon class="paws-icon headline-text" />
              <span class="headline-text">わんこのお友達を探す</span>
            </h3>
            <p class='intro-text'>
              たくさんのお友達があなたを待っています<br>SNSと連携することで宣伝効果も！
            </p>
            <h4 class='intro-headline'>最近登録したわんこ</h4>
            <v-row v-if="users.length > 0">
              <v-col
                v-for="(user, index) in users.slice(0, 3)"
                :key="index"
                cols="4"
              >
                <v-card
                  hover
                  class="card"
                  @click="clickUser(user)"
                >
                  <v-img :src="getImageUrl(user.dog_image1)" />
                </v-card>
              </v-col>
            </v-row>
            <div class='btn-wrap mt-10 mb-12'>
              <a
                class='white-btn white-btn-text'
                @click="clickAllUsers()"
              >
                お友達をもっと見る<v-icon class="btn-icon black-icon">mdi-chevron-right</v-icon>
              </a>
            </div>
          </div>
          <div class="mb-12">
            <h3 class='headline-dog'>
              <PawsIcon class="paws-icon headline-text" />
              <span class="headline-text">飼い主さんの犬種診断</span>
            </h3>
            <p class='intro-text'>
              あなたを犬に例えると...?<br>性別を選択して診断してみよう！
            </p>
            <v-row>
              <v-col cols="6">
                <v-card
                hover
                class="card"
                @click="clickGenderMale()"
              >
                  <v-img :src="require('~/assets/image/diagnosis/male.png')" />
                </v-card>
              </v-col>
              <v-col cols="6">
                <v-card
                  hover
                  class="card"
                  @click="clickGenderFemale()"
                >
                  <v-img :src="require('~/assets/image/diagnosis/female.png')" />
                </v-card>
              </v-col>
            </v-row>
          </div>
          <div>
            <h3 class="headline-dog">
              <PawsIcon class="paws-icon headline-text" />
              <span class="headline-text">犬種図鑑</span>
            </h3>
            <p class="intro-text">
              犬博士になろう！
            </p>
            <v-row v-if="breeds.length > 0">
              <v-col
                v-for="(breed, index) in breeds.slice(0, 3)"
                :key="index"
                cols="4"
              >
                <v-card
                  hover
                  class="card"
                  @click="clickBreed(index)"
                >
                  <v-img :src="require(`@/assets/image/breed/${breed.dog_image}`)" />
                </v-card>
                <div class="name-text mb-0">
                  <a @click="clickBreed(index)">
                    {{ breed.name }}
                  </a>
                </div>
              </v-col>
            </v-row>
            <div class="btn-wrap mt-10">
              <a
                class="white-btn white-btn-text"
                @click="clickAllBreed"
              >
                犬種図鑑をもっと見る
                <v-icon class="btn-icon black-icon">mdi-chevron-right</v-icon>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="!$store.$auth.loggedIn"
      class="text-center ml-4 mr-4"
    >
      <p class='big2-text mb-0 mt-10'>
        簡単登録してはじめよう！
      </p>
      <p class='intro-text'>
        愛犬のなまえ、性別、犬種、SNSアカウントを登録してわんこランキングに参加しよう！
      </p>
      <div class='btn-wrap mt-5'>
        <a
          class='btn-text blue-btn'
          @click='clickSignup()'
        >
          今すぐ登録して始める<v-icon color="white" class="btn-icon">mdi-chevron-right</v-icon>
        </a>
      </div>
      <div class="text-center mt-5">
        <a
          class="btn-under-text"
          @click="clickLogin()"
        >
          アカウントをお持ちの方はこちら
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import PawsIcon from '@/assets/image/svg/paws-icon.svg'
import RankFirst from '@/assets/image/svg/rank/1st.svg'
import RankSecound from '@/assets/image/svg/rank/2nd.svg'
import RankThird from '@/assets/image/svg/rank/3rd.svg'
import UserDialog from '@/components/Common/UserDialog'
import ranking from '@/plugins/modules/ranking'
import breed from '@/plugins/modules/breed'
import user from '@/plugins/modules/user'
import favorite from '@/plugins/modules/favorite'

export default {
  components: {
    UserDialog,
    PawsIcon,
    RankFirst,
    RankSecound,
    RankThird
  },
  auth: false,
  middleware: 'update_user_status',
  data () {
    return {
      dogRanking: [],
      users: [],
      breeds: [],
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
      pages: null,
      length: 3,
      onboarding: 1,
    }
  },
  created() {
    this.fetchData()
  },
  methods: {
    async fetchData() {
      if (this.$auth.loggedIn) {
        this.dogRanking = await ranking.getRankingWithFriends().then((response) => response)
        this.users = await user.getUsersRandomWithFriends().then((response) => response)
      } else {
        this.dogRanking = await ranking.getRanking().then((response) => response)
        this.users = await user.getUsersRandom().then((response) => response)
      }
      this.breeds = await breed.getBreedsRandom().then((response) => response)
    },
    clickSignup() {
      this.$router.push('signup')
    },
    clickDiagnosis() {
      this.$router.push('diagnosis')
    },
    clickImage(index) {
      this.pages = 'ranking'
      this.dogInfo = this.dogRanking[index]
      this.userDialog = true
    },
    choiceClose() {
      this.userDialog = false
    },
    clickAllBreed() {
      this.$router.push('/breed');
    },
    clickBreed(index) {
      const breed = this.breeds[index].dog_image.replace(".png", "")
      this.$router.push(`/breed/detail/${breed}`);
    },
    clickGenderMale() {
      this.$router.push({ path: '/diagnosis', query: { gender: 'male' } });
    },
    clickGenderFemale() {
      this.$router.push({ path: '/diagnosis', query: { gender: 'female' } });
    },
    clickUser(user) {
      this.pages = 'users'
      this.userDialog = true
      this.dogInfo = user
    },
    clickAllUsers() {
      this.$router.push('/dog');
    },
    clickLogin() {
      this.$router.push('/login');
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
    },
    clickLeft() {
      this.onboarding = (this.onboarding - 1 + this.length) % this.length
    },
    clickRight() {
      this.onboarding = (this.onboarding + 1) % this.length
    },
    getImageUrl(image) {
      if (!image) {
        image = '1.jpg';
      }
      return `${process.env.imageBaseUrl}/${image}`;
    },
    getRankComponent(index) {
      if (index === 0) return "RankFirst";
      if (index === 1) return "RankSecound";
      if (index === 2) return "RankThird";
      return null;
    },
  }
}
</script>

<style scoped>

a {
  text-decoration: none;
}

.custom-arrow {
  color: #84D1E2 !important;
  background-color: rgba(215, 237, 242, 0.5) !important;
  border-radius: 50% !important;
}

.banner >>> .v-window__prev {
  background-color: rgba(255, 255, 255, 0) !important;
}

.banner >>> .v-window__next {
  background-color: rgba(255, 255, 255, 0) !important;
}

.all {
  min-width: 350px;
  max-width: 600px;
  margin: 0 auto;
}

.banner {
  max-height: 600px;
  max-width: 600px;
}

.headline-text {
  font-size: 1.2em;
  vertical-align: middle;
  color: #505050;
}

.ranking-col {
  padding: 4px;
  position: relative;
}

.headline-dog {
  margin-top: 20px;
  margin-bottom: 10px;
  text-align: left;
}

.paws-icon {
  width: 1.2em;
  height: 1.2em;
}

.ranking-line {
  margin: -4px;
}

.ranking-icon {
  position: absolute;
  z-index: 2;
  bottom: 7px;
  right: 7px
}

.main-wrap {
  background-color: #D7EDF2;
  border-radius: 500px / 100px;
  padding-top: 50px;
}

.btn-wrap {
  text-align: center;
}

.btn-text {
  border-radius: 30px;
  color: white;
  padding: 15px;
  display: inline-block;
  font-weight: bolder;
  max-width: 600px;
  min-width: 200px;
}

.white-btn-text {
  border-radius: 30px;
  color: #505050;
  padding: 15px;
  display: inline-block;
  font-weight: bolder;
  max-width: 600px;
  min-width: 200px;
}

.blue-btn {
  background-color: #84D1E2;
  max-width: 600px;
  width: 100%;
  padding-top: 20px;
  padding-bottom: 20px;
}

.white-btn {
  background-color: #ffffff;
  max-width: 600px;
  width: 100%;
  padding-top: 16px;
  padding-bottom: 16px;
  border: 4px solid;
  border-color: #84D1E2;
}

.btn-icon {
  margin-bottom: 2px;
}

.black-icon {
  color: #505050;
}

.btn-under-text {
  color: #505050;
  text-decoration: underline;
  text-underline-offset: 5px;
}

.intro-wrap {
  text-align: center;
  width: 100%;
  padding-bottom: 50px
}

.intro-text-wrap {
  max-width: 600px;
  margin: 0 auto;
}

.intro-headline {
  font-size: 16px;
  margin-bottom: 10px;
  text-align: left;
  color: #505050;
  text-decoration: underline;
  text-decoration-thickness: 0.5em;
  text-decoration-color: rgba(132, 209, 226, 0.6);
  text-underline-offset: -0.2em;
  text-decoration-skip-ink: none;
}

.intro-text {
  text-align: left;
  font-size: 15px;
  color: #505050;
  padding: 10px 0;
  margin-bottom: 0;
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

.text {
  font-size: 28px;
  margin: 0 auto;
  max-width: 600px;
  color: #505050;
  font-weight: bold;
  letter-spacing: 2px;
}

.big-text {
  font-size: 38px;
}

.big2-text {
  font-size: 25px;
  font-weight: bold;
}

.text-liner {
  background : linear-gradient(transparent 70%, rgba(132, 209, 226, .6) 70%);
}

.text-wrap {
  max-width: 600px;
  margin: 0 auto;
}

@media screen and (min-width: 600px) {
  .headline {
    font-size: 25px;
  }

  .ranking-icon {
    max-width: 30px;
  }

  .intro-headline {
    font-size: 30px;
    margin-top: 30px;
  }

  .intro-text-wrap {
    max-width: 600px;
  }

  .intro-text {
    font-size: 20px;
    letter-spacing: 5px;
  }
}
</style>