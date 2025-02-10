<template>
    <div class="all">
      <p class="big-text d-flex justify-center mb-8">性別</p>
      <div class="card-wrap">
        <v-row>
          <v-col cols="6">
            <v-btn
              @click="clickGender('male')"
              depressed
              :color="selectedGender === 'female' ? 'grey lighten-2' : 'primary'"
              block
              dark
              class="responsive-btn"
            >
              男性
            </v-btn>
          </v-col>
          <v-col cols="6">
            <v-btn
              @click="clickGender('female')"
              depressed
              :color="selectedGender === 'male' ? 'grey lighten-2' : 'primary'"
              block
              dark
              class="responsive-btn"
            >
              女性
            </v-btn>
          </v-col>
        </v-row>
      </div>
    </div>
  </template>

  <script>
  export default {
    name: 'DiagnosisGender',
    data() {
      return {
        selectedGender: null
      };
    },
    methods: {
      clickGender(gender) {
        this.selectedGender = gender;
        this.$emit('click-gender', this.selectedGender)
      }
    }
  }
  </script>

  <style scoped>
  .big-text {
    font-size: 1.2em;
    color: #505050;
    font-weight: bold;
  }

  .card-wrap {
    padding-top: 30px;
    text-align: center;
  }

  .btn-wrap {
    text-align: center;
  }

  .back-btn:hover {
    outline: none;
    border: 2px solid #B9C9CE;
  }

  .responsive-btn {
    font-weight: bold;
    font-size: 1.2em;
    height: auto;
    min-height: 50px;
    padding: 15px 0;
  }

  @media screen and (min-width: 600px) {
    .responsive-btn {
      font-size: 1.5em;
      min-height: 70px;
      padding: 20px 0;
    }
  }

  @media screen and (min-width: 900px) {
    .responsive-btn {
      font-size: 2em;
      min-height: 100px;
      padding: 30px 0;
    }
  }

  @media screen and (min-width: 600px) {
    .big-text {
      font-size: 1.8em;
      color: #505050;
    }

    .card {
      margin: 20px;
    }
  }
  </style>
