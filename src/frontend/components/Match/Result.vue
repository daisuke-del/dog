<template>
  <div>
      <v-row>
        <v-col cols="12" v-for="match in matchResults" :key="match.img" class="card-wrap">
          <v-card
              class="result-card"
          >
            <v-img
                :src="'@/assets/faceimages/nface_image/' + match.img"
                class="result-img"
            />
            <p class="name-text">{{ match.name }}</p>
            <p class="salary-text">{{ match.salary }}</p>
            <div class="icon-wrap">
              <v-btn
                  icon
              >
                <v-icon
                    size="2em"
                >
                  mdi-twitter
                </v-icon>
              </v-btn>
              <v-btn
                  icon
              >
                <v-icon
                    size="2em"
                >
                  mdi-instagram
                </v-icon>
              </v-btn>
              <v-btn
                  icon
              >
                <v-icon
                    size="2em"
                >
                  mdi-facebook
                </v-icon>
              </v-btn>
              <v-btn
                  icon
                  class="icon-right"
              >
                <v-icon
                    size="2.5em"
                >
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
  data () {
    return {
    }
  }
}
</script>

<style scoped>
.name-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
  margin-top: 16px;
  margin-left: 10px;
  margin-right: 10px;
}

.salary-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
  margin-top: 16px;
  margin-left: 10px;
  margin-right: 10px;
}

.card-wrap {
  margin-top: 30px;
}

.result-card {
  margin-left: 20%;
  margin-right: 20%;
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

@media screen and (min-width: 700px) {
  .result-card {
    margin-left: 35%;
    margin-right: 35%;
  }
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2em;
  }
}
</style>