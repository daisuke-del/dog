<template>
  <div>
    <p class="big-text d-flex justify-center">年齢を入力してください</p>
    <div class="age-wrap">
      <input
        class="age-box"
        type="text"
        maxlength="1"
        v-model="age10"
        @input="validate10"
        ref="r1"
      />
      <input
        class="age-box"
        type="text"
        maxlength="1"
        v-model="age01"
        @input="validate01"
        ref="r2"
        @keydown.delete="backBox"
      />
      <p class="age-text big-text">歳</p>
    </div>
    <div class="btn-wrap">
      <button class="back-btn" @click="$router.back()">戻る</button>
      <button class="next-btn" @click="saveSessionAge">次へ</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      url: 'http://127.0.0.1:8000/api/',
      age10: null,
      age01: null,
      errors: [],
    }
  },
  methods: {
    validate10() {
      this.age10 = this.age10.replace(/\D/g, '')
    },
    validate01() {
      this.age01 = this.age01.replace(/\D/g, '')
    },
    backBox: function (e) {
      if (e.target.value == '') {
        this.$refs.r1.focus()
      }
    },
    saveSessionAge() {
      const age = this.age10 * 10 + this.age01
      const url = this.url + 'match/age'
      axios
        .post(url, {
          age: age,
        })
        .then(() => {
          this.$router.push({ name: 'MatchHeight' })
        })
    },
  },
  watch: {
    age10: function (v) {
      if (v.length >= 1) {
        this.$refs.r2.focus()
      }
    },
  },
}
</script>

<style scoped>
.big-text {
  font-size: 1.5em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.age-wrap {
  text-align: center;
  margin-top: 50px;
}

.age-box {
  border: 2px solid #b9c9ce;
  border-radius: 5px;
  height: 60px;
  max-width: 60px;
  margin: 10px;
  font-size: 1.5em;
  text-align: center;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.age-text {
  display: inline-block;
  margin: 0;
}

input[type='text']:focus {
  border: none;
  outline: 2px solid black;
}

.btn-wrap {
  text-align: center;
  margin-right: 20px;
}

.next-btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
  background-color: white;
  width: 100px;
  height: 30px;
  border-radius: 0.3em;
  outline: 1px solid #b9c9ce;
  margin: 50px 0 15px 15px;
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
  margin: 50px 0 15px 15px;
}

.next-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

.back-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2em;
  }

  .age-wrap {
    margin-top: 50px;
  }

  .age-box {
    height: 70px;
    max-width: 70px;
    margin: 15px;
    font-size: 2em;
    text-align: center;
  }

  .age-text {
    margin-left: 10px;
  }
  
  .btn-wrap {
    margin-right: 50px;
  }
}
</style>
