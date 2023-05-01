<template>
    <div class="all">
      <p class="big-text d-flex justify-center mb-2">性別を選択してください</p>
      <div class="card-wrap">
        <v-card hover class="card" @click="clickGender('male')">
          <v-img :src="require('~/assets/image/diagnosis/male.png')" />
        </v-card>
        <v-card hover class="card" @click="clickGender('female')">
          <v-img :src="require('~/assets/image/diagnosis/female.png')" />
        </v-card>
      </div>
    </div>
  </template>

  <script>
  export default {
    name: 'DiagnosisGender',
    methods: {
      clickGender(gender) {
        this.$emit('click-gender', gender)
      }
    }
  }
  </script>

  <style scoped>
  .all {
    margin-right: 20px;
  }

  .big-text {
    font-size: 1.3em;
    font-family: 'Noto Sans JP', sans-serif;
    color: slategray;
  }

  .card-wrap {
    text-align: center;
  }

  .card {
    display: inline-block;
    width: 40%;
    max-width: 250px;
    margin: 10px;
  }

  .btn-wrap {
    text-align: center;
  }

  .back-btn:hover {
    outline: none;
    border: 2px solid #B9C9CE;
  }

  @media screen and (min-width: 600px) {
    .big-text {
      font-size: 2.3em;
    }

    .card {
      margin: 20px;
    }
  }
  </style>
