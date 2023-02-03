<template>
  <div>
    <v-row>
      <v-col cols="12" sm="6" v-for="(match, index) in matchResults" :key="index" class="card-wrap">
        <v-card light :class="match.mutualLove === 1 ? 'result-card-match' : 'result-card'">
          <v-img :src="require(`@/../storage/image/faceimages/${match.face_image}`)" class="result-img" />
          <p class="card-text mt-4">{{ match.name }}</p>
          <p class="card-text pb-4">年収 {{ match.salary }}万円</p>
          <div v-if="$auth.loggedIn && $store.getters['authInfo/gender'] !== match.gender" class="icon-wrap">
            <v-btn v-if="match.twitter_id" @click="clickTwitter(match.twitter_id)" icon>
              <v-icon size="2em">
                mdi-twitter
              </v-icon>
            </v-btn>
            <v-btn v-if="match.instagram_id" @click="clickInstagram(match.instagram_id)" icon>
              <v-icon size="2em">
                mdi-instagram
              </v-icon>
            </v-btn>
            <v-btn v-if="match.facebook_id"  @click="clickFacebook(match.facebook_id)" icon>
              <v-icon size="2em">
                mdi-facebook
              </v-icon>
            </v-btn>
            <v-btn v-if="match.onesideLove === 1" @click="deleteFavorite(match.user_id, index)" icon class="icon-right">
              <v-icon size="2.5em" color="pink">
                mdi-heart
              </v-icon>
            </v-btn>
            <v-btn v-else @click="addFavorite(match.user_id, index)" icon class="icon-right">
              <v-icon size="2.5em">
                mdi-heart
              </v-icon>
            </v-btn>
          </div>
        </v-card>
      </v-col>
    </v-row>
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
    clickTwitter(url) {
      window.open(url, '_blank')
    },
    clickInstagram(url) {
      window.open(url, '_blank')
    },
    clickFacebook(url) {
      window.open(url, '_blank')
    },
    addFavorite(friendId, index) {
      console.log(friendId, index)
      this.$emit('add-favorite', friendId, index)
    },
    deleteFavorite(friendId, index) {
      this.$emit('delete-favorite', friendId, index)
    }
  }
}
</script>

<style scoped>
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
}

.result-card-match {
  margin-left: 10%;
  margin-right: 10%;
  background-color: rgb(251, 176, 214);
}

.icon-wrap {
  padding-bottom: 10px;
  margin-left: 10px;
  margin-right: 10px;
}

.icon-right {
  float: right;
  margin-right: 5px;
  margin-bottom: 5px;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2em;
  }

  .card-text {
    font-size: 1.4em;
  }
}
</style>