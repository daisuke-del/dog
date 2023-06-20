<template>
    <div class="all">
      <p class="big-text d-flex justify-center">あなたの顔のタイプを選択</p>
      <div v-if="gender==='male'" class="face-wrap">
        <v-row>
          <v-col cols="6">
              <v-card @click="clickFace(1)">
                  <v-img
                    :src="require('~/assets/image/diagnosis/face/male/fresh.png')"
                  />
                  <v-card-text class="face-text fresh">フレッシュ</v-card-text>
              </v-card>
          </v-col>
          <v-col cols="6">
              <v-card @click="clickFace(2)">
                  <v-img
                    :src="require('~/assets/image/diagnosis/face/male/charming.png')"
                  />
                  <v-card-text class="face-text charming">チャーミング</v-card-text>
              </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6">
              <v-card @click="clickFace(3)">
                  <v-img
                    :src="require('~/assets/image/diagnosis/face/male/cool.png')"
                  />
                  <v-card-text class="face-text cool">クール</v-card-text>
              </v-card>
          </v-col>
          <v-col cols="6">
              <v-card @click="clickFace(4)">
                  <v-img
                    :src="require('~/assets/image/diagnosis/face/male/elegant.png')"
                  />
                  <v-card-text class="face-text elegant">エレガント</v-card-text>
              </v-card>
          </v-col>
        </v-row>
      </div>
      <div v-else class="face-wrap">
        <v-row>
          <v-col cols="6">
              <v-card @click="clickFace(1)">
                  <v-img
                    :src="require('~/assets/image/diagnosis/face/female/fresh.png')"
                  />
                  <v-card-text class="face-text fresh">フレッシュ</v-card-text>
              </v-card>
          </v-col>
          <v-col cols="6">
              <v-card @click="clickFace(2)">
                  <v-img
                    :src="require('~/assets/image/diagnosis/face/female/charming.png')"
                  />
                  <v-card-text class="face-text charming">チャーミング</v-card-text>
              </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6">
              <v-card @click="clickFace(3)">
                  <v-img
                    :src="require('~/assets/image/diagnosis/face/female/cool.png')"
                  />
                  <v-card-text class="face-text cool">クール</v-card-text>
              </v-card>
          </v-col>
          <v-col cols="6">
              <v-card @click="clickFace(4)">
                  <v-img
                    :src="require('~/assets/image/diagnosis/face/female/elegant.png')"
                  />
                  <v-card-text class="face-text elegant">エレガント</v-card-text>
              </v-card>
          </v-col>
        </v-row>
      </div>
      <div class="btn-wrap">
        <button class="back-btn" @click="clickBack()">戻る</button>
      </div>
    </div>
  </template>

  <script>
  export default {
    name: 'DiagnosisFace',
    props: {
      gender: {
        type: String,
        required: false
      }
    },
    methods: {
      clickBack () {
        this.$emit('click-back', 3)
      },
      clickFace (value) {
        this.$emit('click-face', value)
      }
    }
  }
  </script>

  <style scoped>
  .all {
    margin-right: 20px;
  }

  .face-wrap {
    max-width: 500px;
    margin: 0 auto;
  }

  .face-text {
    padding: 4px;
  }

  .fresh {
    background: rgb(235, 248, 187);
  }

  .charming {
    background: rgb(254, 232, 143);
  }

  .cool {
    background: rgb(208, 239, 254);
  }

  .elegant {
    background: rgb(249, 216, 253);
  }

  .big-text {
    font-size: 1.3em;
    font-family: 'Noto Sans JP', sans-serif;
    color: slategray;
  }

  .btn-wrap {
    text-align: center;
  }

  .back-btn {
    font-family: 'Noto Sans JP', sans-serif;
    font-size: 1em;
    color: slategray;
    background-color: white;
    width: 100px;
    height: 30px;
    border-radius: .3em;
    outline: 1px solid #B9C9CE;
    margin: 20px 17px 5px 0;
  }

  .back-btn:hover {
    outline: none;
    border: 2px solid #B9C9CE;
  }

  @media screen and (min-width: 600px) {
    .big-text {
      font-size: 2.3em;
    }

    .back-btn {
      font-size: 1.5em;
      width: 200px;
      height: 50px;
    }

    .btn-wrap {
      margin-top: 30px;
      margin-right: 30px;
    }
  }
  </style>