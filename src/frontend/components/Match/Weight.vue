<template>
  <div>
    <common-flame>
      <p class="big-text d-flex justify-center">体重を入力してください</p>
      <div class="weight-wrap">
        <input class="weight-box" type="text" maxlength="1" v-model="weight100" @input="validate100" ref="r1">
        <input class="weight-box" type="text" maxlength="1" v-model="weight10" @input="validate10" ref="r2" @keydown.delete="backBox">
        <input class="weight-box" type="text" maxlength="1" v-model="weight01" @input="validate01" ref="r3" @keydown.delete="backBox2">
        <p class="weight-text big-text">kg</p>
      </div>
      <div class="btn-wrap">
        <button
            class="back-btn"
            @click="$router.back()"
        >戻る</button>
        <button
            class="next-btn"
            @click="saveSessionWeight"
        >次へ</button>
      </div>
    </common-flame>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: 'MatchWeight',
  data() {
    return {
      url: 'http://127.0.0.1:8000/api/',
      weight100: '0',
      weight10: null,
      weight01: null,
      errors: []
    }
  },
  methods: {
    validate100() {
      this.weight100 = this.weight100.replace(/\D/g, '')
    },
    validate10() {
      this.weight10 = this.weight10.replace(/\D/g, '')
    },
    validate01() {
      this.weight01 = this.weight01.replace(/\D/g, '')
    },
    backBox(e) {
      if (e.target.value === "") {
        this.$refs.r1.focus()
      }
    },
    backBox2(e) {
      if (e.target.value === "") {
        this.$refs.r2.focus()
      }
    },
    saveSessionWeight(){
      const weight = this.weight100 + this.weight10 + this.weight01 ;
      const url = this.url + 'match/weight'
      axios.post(url, {
        weight
      }).then(() => {
            this.$router.push({name: 'MatchSalary'});
          }
      )}
  },
  watch: {
    weight100(v) {
      if (v.length >= 1) {
        this.$refs.r2.focus()
      }
    },
    weight10(v) {
      if (v.length >= 1) {
        this.$refs.r3.focus()
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

.weight-wrap {
  text-align: center;
  margin-top: 50px;
  margin-bottom: 50px;
}

.weight-box {
  border: 2px solid #B9C9CE;
  border-radius:5px;
  height: 60px;
  max-width: 60px;
  margin: 10px;
  font-size: 1.5em;
  text-align: center;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.weight-text {
  display: inline-block;
  margin: 0;
}

input[type="text"]:focus {
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
  border-radius: .3em;
  outline: 1px solid #B9C9CE;
  margin: 20px 0 15px 15px;
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
  margin: 20px 0 15px 15px;
}

.next-btn:hover {
  outline: none;
  border: 2px solid #B9C9CE;
}

.back-btn:hover {
  outline: none;
  border: 2px solid #B9C9CE;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2em;
  }

  .weight-wrap {
    margin-top: 50px;
  }

  .weight-box {
    height: 70px;
    max-width: 70px;
    margin: 15px;
    font-size: 2em;
    text-align: center;
  }

  .weight-text {
    margin-left: 10px;
  }

  .btn-wrap {
    margin-right: 50px;
  }
}
</style>