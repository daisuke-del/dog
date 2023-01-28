<template>
  <div>
    <v-row>
      <v-col cols="12" v-for="match in matchResults" :key="match.face_image" class="card-wrap">
        <v-card light class="result-card">
          <v-img :src="require(`@/../storage/image/faceimages/${match.face_image}`)" class="result-img" />
          <p class="name-text">{{ match.name }}</p>
          <p class="salary-text">年収</p>
          <p class="salary-text mb-3">{{ match.salary }}万円</p>
          <div v-if="$auth.loggedIn" class="icon-wrap">
            <v-btn @click="clickTwitter(match.twitter_id)" icon>
              <v-icon size="2em">
                mdi-twitter
              </v-icon>
            </v-btn>
            <v-btn @click="clickInstagram(match.instagram_id)" icon>
              <v-icon size="2em">
                mdi-instagram
              </v-icon>
            </v-btn>
            <v-btn @click="clickFacebook(match.facebook_id)" icon>
              <v-icon size="2em">
                mdi-facebook
              </v-icon>
            </v-btn>
            <v-btn @click="updateFavorite" icon class="icon-right">
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
    updateFavorite() {
      
    }
  }
}
</script>

<style scoped>
.name-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  font-weight: bolder;
  color: slategray;
  margin-top: 16px;
  margin-left: 10px;
  margin-right: 10px;
}

.salary-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  font-weight: bolder;
  color: slategray;
  margin-bottom: 0;
}

.card-wrap {
  margin-top: 30px;
}

.result-card {
  margin-left: 10%;
  margin-right: 10%;
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

@media screen and (min-width: 400px) {
  .result-card {
    margin-left: 20%;
    margin-right: 20%;
  }
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2em;
  }
  .result-card {
    margin-left: 30%;
    margin-right: 30%;
  }
}
</style>