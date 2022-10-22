<template>
  <div>
    <p class="big-text d-flex justify-center">年収を選択してください</p>
    <div class="salary-wrap d-flex justify-center">
      <v-select
        :items="salaryRange"
        v-model="item"
        label="年収を選択"
        hide-details
        solo
        flat
        height="80px"
        class="salary-box"
      />
      <p class="salary-text big-text">万円</p>
    </div>
    <div class="btn-wrap">
      <button class="back-btn" @click="clickBack()">戻る</button>
      <button  v-if="item != null" class="next-btn" @click="clickSalary()">次へ</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MatchSalary',
  data () {
    return {
      salaryRange: [
        '〜 199',
        '200 〜 399',
        '400 〜 599',
        '600 〜 799',
        '800 〜 999',
        '1000 〜 1999',
        '2000 〜 2999',
        '3000 〜',
      ],
      item: null,
      salary: null,
    }
  },
  methods: {
    clickSalary () {
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
      this.$emit('click-salary', this.salary)
    },
    clickBack () {
      this.$emit('click-back', 4)
    },
    resetSalary () {
      this.salary = null
      this.item = null
    }
  },
}
</script>

<style scoped>
.big-text {
  font-size: 1.3em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.salary-wrap {
  align-items: center;
}

.salary-text {
  display: inline-block;
  width: 80px;
  text-align: center;
  padding-left: 5px;
  margin: 0;
}

.salary-box {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1.3em;
  max-width: 300px;
  min-width: 100px;
  border: 2px solid #b9c9ce;
  border-radius: 5px;
}

.btn-wrap {
  text-align: center;
  height: 60px;
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
  margin: 20px 0 15px 15px;
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
  margin: 20px 0 15px 15px;
}

.next-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

.back-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

.v-select >>> .v-select__selections {
  color: slategray;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2.3em;
  }

  .salary-wrap {
    height: 100px;
    margin-top: 30px;
    margin-bottom: 30px;
  }

  .salary-text {
    margin-left: 10px;
  }

  .btn-wrap {
    margin-right: 40px;
    height: 100px;
  }

  .back-btn,
  .next-btn {
    font-size: 1.5em;
    width: 200px;
    height: 50px;
  }
}
</style>
