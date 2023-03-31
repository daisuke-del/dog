<template>
  <div class="all">
    <p class="big-text d-flex justify-center mb-2">性別を選択してください</p>
    <div class="card-wrap">
      <v-card hover class="card" @click="clickSex('male')">
        <v-img :src="'http://localhost/storage/images/male.jpeg'" />
      </v-card>
      <v-card hover class="card" @click="clickSex('female')">
        <v-img :src="'http://localhost/storage/images/female.jpeg'" />
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MatchSex',
  data() {
    return {
      sex: null
    }
  },
  methods: {
    clickSex(sex) {
      this.sex = sex
      this.$emit('click-sex', this.sex)
    },
    resetSex() {
      this.sex = null
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
