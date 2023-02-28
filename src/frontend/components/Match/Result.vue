<template>
  <div class="all">
    <p v-if="!$auth.loggedIn" class="result-text"><a @click="clickSignup">会員登録</a>するといいね！が送れるよ</p>
    <v-row>
      <v-col cols="12" sm="6" v-for="(match, index) in matchResults" :key="index" class="card-wrap">
        <v-card light :class="match.mutualLove === 1 ? 'result-card-match' : 'result-card'">
          <div class="ranking-icon">
            <v-img
              v-if="index === 0"
              :src="require('@/assets/image/rank/1st.png')"
            />
            <v-img
              v-else-if="index === 1"
              :src="require('@/assets/image/rank/2nd.png')"
            />
            <v-img
              v-else-if="index === 2"
              :src="require('@/assets/image/rank/3rd.png')"
            />
            <v-img
              v-if="match.mutualLove === 1"
              :src="require('@/assets/image/other/friend-icon.png')"
            />
          </div>
          <v-img :src="require(`@/../storage/image/faceimages/${match.face_image}`)" class="result-img" />
          <p class="card-text mt-4">{{ match.name }}</p>
          <p class="card-text mb-0 pb-4">年収 {{ match.salary }}万円</p>
          <div v-if="$auth.loggedIn && $store.getters['authInfo/gender'] !== match.gender" class="icon-wrap">
            <v-btn v-if="match.twitter_id && match.mutualLove === 1" @click="clickTwitter(match.twitter_id)" icon>
              <v-icon size="2em" color="#1DA1F2">
                mdi-twitter
              </v-icon>
            </v-btn>
            <v-btn v-if="match.instagram_id && match.mutualLove === 1 " @click="clickInstagram(match.instagram_id)" icon>
              <v-icon size="2em" color="#C13584">
                mdi-instagram
              </v-icon>
            </v-btn>
            <v-btn v-if="match.facebook_id && match.mutualLove === 1 "  @click="clickFacebook(match.facebook_id)" icon>
              <v-icon size="2em" color="#4267B2">
                mdi-facebook
              </v-icon>
            </v-btn>
            <v-btn v-if="match.onesideLove === 1" @click="deleteFavorite(match.user_id, index)" icon>
              <v-icon size="2.5em" color="pink">
                mdi-heart
              </v-icon>
            </v-btn>
            <v-btn v-else @click="addFavorite(match.user_id, index)" icon>
              <v-icon size="2.5em">
                mdi-heart
              </v-icon>
            </v-btn>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <v-btn
      block
      height="40px"
      depressed
      color="#fd7e00"
      class="font-weight-bold mb-10 mt-5"
      @click="reTry"
    >
      もう一度診断する
    </v-btn>
  </div>
</template>

<script>
export default {
  name: 'MatchResult',
  props: {
    matchResults: {
      type: Array,
      requred: true
    }
  },
  methods: {
    clickSignup() {
      this.$router.push('signup')
    },
    clickTwitter(url) {
      const link = 'https://www.twitter.com/' + url
      window.open(link, '_blank')
    },
    clickInstagram(url) {
      const link = 'https://www.instagram.com/' + url
      window.open(link, '_blank')
    },
    clickFacebook(url) {
      const link = 'https://ja-jp.facebook.com/' + url
      window.open(link, '_blank')
    },
    addFavorite(friendId, index) {
      this.$emit('add-favorite', friendId, index)
    },
    deleteFavorite(friendId, index) {
      this.$emit('delete-favorite', friendId, index)
    },
    reTry() {
      this.$router.go({path: this.$router.currentRoute.path, force: true})
    }
  }
}
</script>

<style scoped>
.result-text {
  color: slategray;
  font-family: 'Noto Sans JP', sans-serif;
  font-weight: bold;
  font-size: 1.2em;
  margin-bottom: 0;
  margin-top: 20px;
}

.card-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  font-weight: bolder;
  color: slategray;
}

.card-wrap {
  margin-top: 30px;
}

.result-card {
  margin-left: 10%;
  margin-right: 10%;
  position: relative;
}

.result-card-match {
  margin-left: 10%;
  margin-right: 10%;
  background-color: #fef9e4;
  position: relative;
}

.icon-wrap {
  padding-bottom: 10px;
  margin-left: 10px;
  margin-right: 10px;
}

.icon-right-match {
  float: right;
  margin-right: 5px;
  margin-bottom: 15px;
}

.ranking-icon {
  z-index: 2;
  position: absolute;
  top: -2%;
  left: -6%;
  max-width: 70px;
}

@media screen and (min-width: 600px) {
  .result-text {
    font-size: 1.5em;
  }

  .big-text {
    font-size: 2em;
  }

  .card-text {
    font-size: 1.4em;
  }
}
</style>