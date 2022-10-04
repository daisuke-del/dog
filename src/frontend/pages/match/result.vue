<template>
  <div>
      <v-row>
        <v-col cols="12" v-for="much in muchs" :key="much.img" class="card-wrap">
          <v-card
              class="result-card"
          >
            <v-img
                :src="'@/assets/faceimages/nface_image/' + much.img"
                class="result-img"
            />
            <p class="name-text">{{ much.name }}</p>
            <p class="salary-text">{{ much.salary }}</p>
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
  data() {
    return {
      muchs: [
        { name: '田中姫', img: 'face_image/99.jpeg', twitter: 'https://twitter.com/hirox246', salary: '500万円'},
        { name: '遠藤香織', img: 'face_image/90.jpeg', twitter: 'https://twitter.com/hirox246', salary: '500万円'},
        { name: '小田公子', img: 'face_image/83.jpeg', twitter: 'https://twitter.com/hirox246', salary: '500万円'},
        { name: '坂田英里', img: 'face_image/80.jpeg', twitter: 'https://twitter.com/hirox246', salary: '500万円'}
      ]
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