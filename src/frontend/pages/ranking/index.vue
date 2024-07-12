<template>
  <div class='all'>
    <user-dialog
      :dialog.sync="userDialog"
      :dog-info="dogInfo"
      @choice-close="choiceClose"
      @add-favorite="addFavorite"
      @delete-favorite="deleteFavorite"
    />
    <div class='main-wrapper justify-center'>
      <div class='ranking-wrap'>
        <h3 class='ranking-headline'><PawsIcon class="headline-text" /><span class="headline-text">人気のわんこランキング</span></h3>
        <v-row>
          <v-col cols='4' class='ranking-col'>
            <RankFirst class='ranking-icon' />
            <v-card elevation="0">
              <v-img
                :src='dog1'
                @click='clickImage(0)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[0].name }}</p>
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <RankSecound class='ranking-icon' />
            <v-card elevation="0">
              <v-img
                :src='dog2'
                @click='clickImage(1)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[1].name }}</p>
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <RankThird class='ranking-icon' />
            <v-card elevation="0">
              <v-img
                :src='dog3'
                @click='clickImage(2)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[2].name }}</p>
            </v-card>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols='4' class='ranking-col'>
            <v-card elevation="0">
              <v-img
                :src='fourthDog'
                @click='clickImage(3)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[3].name }}</p>
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <v-card elevation="0">
              <v-img
                :src='fifthDog'
                @click='clickImage(4)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[4].name }}</p>
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <v-card elevation="0">
              <v-img
                :src='sixthDog'
                @click='clickImage(5)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[5].name }}</p>
            </v-card>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols='4' class='ranking-col'>
            <v-card elevation="0">
              <v-img
                :src='seventhDog'
                @click='clickImage(6)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[6].name }}</p>
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <v-card elevation="0">
              <v-img
                :src='eighthDog'
                @click='clickImage(7)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[7].name }}</p>
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <v-card elevation="0">
              <v-img
                :src='ninethDog'
                @click='clickImage(8)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[8].name }}</p>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols='4' class='ranking-col'>
            <v-card elevation="0">
              <v-img
                :src='tenthDog'
                @click='clickImage(9)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[9].name }}</p>
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <v-card elevation="0">
              <v-img
                :src='eleventhDog'
                @click='clickImage(10)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[10].name }}</p>
            </v-card>
          </v-col>
          <v-col cols='4' class='ranking-col'>
            <v-card elevation="0">
              <v-img
                :src='twelvethDog'
                @click='clickImage(11)'
              />
              <p class="mb-0 ml-1">{{ dogRanking[11].name }}</p>
            </v-card>
          </v-col>
        </v-row>
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
  async asyncData({ app }) {
    let dogRanking = []
    if (app.$auth.loggedIn) {
      await ranking.getRankingWithFriends().then((response) => {
        dogRanking = response
      })
    } else {
      await ranking.getRanking().then((response) => {
        dogRanking = response
      })
    }
    return {
      dogRanking
    }
  },
  data () {
    return {
      dogRanking: [],
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
    dog1 () {
      return this.dogRanking[0].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[0].dog_image1}`)
    },
    dog2 () {
      return this.dogRanking[1].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[1].dog_image1}`)
    },
    dog3 () {
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
    },
    twelvethDog () {
      return this.dogRanking[11].dog_image1 && require(`@/../storage/image/dogimages/${this.dogRanking[11].dog_image1}`)
    }
  },
  methods: {
    clickImage (index) {
      this.pages = 'ranking'
      this.dogInfo = this.dogRanking[index]
      this.userDialog = true
    },
    choiceClose () {
      this.userDialog = false
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

p {
  font-size: 14px;
}

.all {
  min-width: 350px;
}

.headline-text {
  vertical-align: middle;
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
  font-size: 16px;
}

.ranking-icon {
  z-index: 2;
  bottom: 26%;
  right: 10%;
  position: absolute;
  max-width: 45px;
}

@media screen and (min-width: 600px) {
  .ranking-wrap {
      max-width: 600px;
      margin: 0 auto;
  }

  .ranking-headline {
      font-size: 25px;
  }

  .ranking-icon {
      max-width: 60px;
  }

}
</style>
