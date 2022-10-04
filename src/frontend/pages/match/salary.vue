<template>
  <div>
    <common-flame>
      <p class="big-text d-flex justify-center">年収を選択してください</p>
      <div class="salary-wrap d-flex justify-center">
        <v-select
            class="salary-box"
            :items="salaryRange"
            v-model="item"
            label="年収を選択"
            hide-details
            prepend-icon="mdi-currency-jpy"
            solo
            color="slategray"
            width="100px"
        />
        <p class="salary-text big-text">万円</p>
      </div>
      <div class="btn-wrap">
        <button
            class="back-btn"
            @click="$router.back()"
        >戻る</button>
        <button
            class="next-btn"
            @click="saveSessionSalary"
        >次へ</button>
        {{ item }}
      </div>
    </common-flame>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      url: 'http://127.0.0.1:8000/api/',
      salaryRange: ['〜 199', '200 〜 399', '400 〜 599', '600 〜 799', '800 〜 999', '1000 〜 1999', '2000 〜 2999', '3000 〜'],
      item: null,
      salary: null
    }
  },
  methods: {
    saveSessionSalary(){
      if (this.item === '〜 199') {
        this.salary = 150
      } else if (this.item === '200 〜 399') {
        this.salary = 300
      } else if (this.item === '400 〜 599') {
        this.salary = 500
      } else if (this.item === '600 〜 799') {
        this.salary = 700
      } else if (this.item === '800 〜 999') {
        this.salary = 900
      } else if (this.item === '1000 〜 1999') {
        this.salary = 1100
      } else if (this.item === '2000 〜 2999') {
        this.salary = 2000
      } else if (this.item === '3000 〜') {
        this.salary = 3000
      }
      const url = this.url + 'match/salary'
      axios.post(url, {
        salary: this.salary
      }).then(() => {
            this.$router.push({name: 'MatchFace'});
          }
      )}
  },
}
</script>

<style scoped>
.big-text {
  font-size: 1.5em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.salary-wrap {
  margin: 50px 50px 30px 30px;
  align-items: center;
}

.salary-text {
  display: inline-block;
  width: 80px;
  text-align: center;
  padding-left:5px ;
  margin: 0;
}

.salary-box {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  width: 100px;
  max-width: 300px;
  min-width: 100px;
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

  .salary-wrap {
    margin-top: 50px;
  }

  .salary-text {
    margin-left: 10px;
  }

  .salary-box {
    width: 300px;
  }
}
</style>