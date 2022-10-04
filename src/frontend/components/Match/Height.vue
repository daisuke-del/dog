<template>
  <div>
      <p class="big-text d-flex justify-center">身長を入力してください</p>
      <div class="height-wrap">
        <input class="height-box" type="text" maxlength="1" v-model="height100" @input="validate100" ref="r1">
        <input class="height-box" type="text" maxlength="1" v-model="height10" @input="validate10" ref="r2" @keydown.delete="backBox">
        <input class="height-box" type="text" maxlength="1" v-model="height01" @input="validate01" ref="r3" @keydown.delete="backBox2">
        <p class="height-text big-text">cm</p>
      </div>
      <div class="btn-wrap">
        <button
            class="back-btn"
            @click="$router.back()"
        >戻る</button>
        <button
            class="next-btn"
            @click="saveSessionHeight"
        >次へ</button>
      </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: 'MatchHeight',
  data() {
    return {
      url: 'http://127.0.0.1:8000/api/',
      height100: '1',
      height10: null,
      height01: null,
      errors: []
    }
  },
  methods: {
    validate100() {
      this.height100 = this.height100.replace(/\D/g, '')
    },
    validate10() {
      this.height10 = this.height10.replace(/\D/g, '')
    },
    validate01() {
      this.height01 = this.height01.replace(/\D/g, '')
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
    saveSessionHeight(){
      const height = this.height100 + this.height10 + this.height01 ;
      const url = this.url + 'match/height'
      axios.post(url, {
        height
      }).then(() => {
            this.$router.push({name: 'MatchWeight'});
          }
      )}
  },
  watch: {
    height100(v) {
      if (v.length >= 1) {
        this.$refs.r2.focus()
      }
    },
    height10(v) {
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

.height-wrap {
  text-align: center;
  align-items: center;
  margin-top: 50px;
  margin-bottom: 50px;
}

.height-box {
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

.height-text {
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

  .height-wrap {
    margin-top: 50px;
  }

  .height-box {
    height: 70px;
    max-width: 70px;
    margin: 15px;
    font-size: 2em;
    text-align: center;
  }

  .height-text {
    margin-left: 10px;
  }
  
  .btn-wrap {
    margin-right: 50px;
  }
}
</style>