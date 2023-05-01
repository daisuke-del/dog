<template>
    <div class="all">
      <p class="big-text">休日を過ごすなら？</p>
      <v-row class="holiday-wrap">
        <v-col cols="6">
          <v-card
            @click="clickHoliday('picnic')"
          >
            <v-img :src="require('~/assets/image/diagnosis/holiday/picnic.png')" />
            <v-card-text class="holiday-text">ピクニック！</v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card
            @click="clickHoliday('game')"
          >
            <v-img :src="require('~/assets/image/diagnosis/holiday/game.png')" />
            <v-card-text class="holiday-text">ゲーム！</v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card
            @click="clickHoliday('party')"
          >
            <v-img :src="require('~/assets/image/diagnosis/holiday/party.png')" />
            <v-card-text class="holiday-text">パーティー！</v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card
            @click="clickHoliday('workholiday')"
          >
            <v-img :src="require('~/assets/image/diagnosis/holiday/book.png')" />
            <v-card-text class="holiday-text">読書！</v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <div class="btn-wrap">
        <button class="back-btn" @click="clickBack()">戻る</button>
      </div>
    </div>
  </template>

  <script>
  export default {
    name: 'DiagnosisHoliday',
    data () {
      return {
        holiday: null
      }
    },
    methods: {
      clickHoliday (holiday) {
        this.holiday = holiday
        this.$emit('click-holiday', this.holiday)
      },
      clickBack () {
        this.$emit('click-back', 5)
      },
      resetHoliday () {
        this.holiday = null
      }
    }
  }
  </script>

  <style scoped>
  .all {
    margin-right:30px ;
  }

  .big-text {
    font-size: 1.2em;
    font-family: 'Noto Sans JP', sans-serif;
    color: slategray;
  }

  .holiday-wrap {
    max-width: 500px;
    margin: 0 auto;
  }

  .holiday-text {
    padding: 4px;
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
    border-radius: 0.3em;
    outline: 1px solid #b9c9ce;
    margin-top: 30px;
    margin-bottom: 10px;
  }

  .back-btn:hover {
    outline: none;
    border: 2px solid #b9c9ce;
  }

  @media screen and (min-width: 600px) {
    .big-text {
      font-size: 2em;
    }

    .back-btn {
      font-size: 1.5em;
      width: 200px;
      height: 50px;
    }
  }
  </style>
