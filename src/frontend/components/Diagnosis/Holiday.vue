<template>
    <div class="all">
      <p class="big-text">休日を過ごすなら？</p>
      <v-row class="holiday-wrap">
        <v-col cols="6">
          <v-card
            @click="clickHoliday('picnic')"
          >
            <v-img :src="require('~/assets/image/diagnosis/holiday/picnic.png')" />
            <v-card-text class="holiday-text">公園で遊ぶ</v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card
            @click="clickHoliday('game')"
          >
            <v-img :src="require('~/assets/image/diagnosis/holiday/game.png')" />
            <v-card-text class="holiday-text">一人で遊ぶ</v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card
            @click="clickHoliday('party')"
          >
            <v-img :src="require('~/assets/image/diagnosis/holiday/party.png')" />
            <v-card-text class="holiday-text">パーティー</v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card
            @click="clickHoliday('workholiday')"
          >
            <v-img :src="require('~/assets/image/diagnosis/holiday/book.png')" />
            <v-card-text class="holiday-text">ゆっくり過ごす</v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-btn
        text
        large
        :x-large="$vuetify.breakpoint.smAndUp"
        color="primary"
        @click="clickBack()"
        class="mt-4"
      >
        戻る
      </v-btn>
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
    color: #505050;
    font-weight: bold;
  }

  .holiday-wrap {
    max-width: 500px;
    margin: 0 auto;
  }

  .holiday-text {
    padding: 4px;
  }

  @media screen and (min-width: 600px) {
    .big-text {
      font-size: 1.8em;
      color: #505050;
    }
  }
  </style>
