<template>
  <div class="all">
    <p class="big-text d-flex justify-center mb-2">性別を選択してください</p>
    <div class="card-wrap">
      <v-card hover class="card" @click="clickGender('male')">
        <v-img :src="'https://www.marigold.red/storage/images/male.jpeg'" />
      </v-card>
      <v-card hover class="card" @click="clickGender('female')">
        <v-img :src="'https://www.marigold.red/storage/images/female.jpeg'" />
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MatchGender',
  data() {
    return {
      gender: null
    }
  },
  methods: {
    clickGender(gender) {
      this.gender = gender
      this.$emit('click-gender', this.gender)
    },
    resetGender() {
      this.gender = null
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
