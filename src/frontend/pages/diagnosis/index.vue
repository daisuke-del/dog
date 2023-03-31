<template>
  <div class="all">
    <h1 v-if="choiceCount < 3 && position === 8">どっちが可愛い？</h1>
    <h1 v-else-if="position === 8">診断結果</h1>
    <h1 v-else>犬診断</h1>
    <diagnosis-choice v-if="choiceCount < 3 && position === 8" :leftImage="choiceFaces[0].dog_image"
      :rightImage="choiceFaces[1].dog_image" @choice-left="choiceLeft" @choice-right="choiceRight"
      @alert-left="clickAlertLeft" @alert-right="clickAlertRight" />
    <diagnosis-result v-else-if="position === 8" :diagnosisResults="diagnosisResults" @add-favorite="addFavorite"
      @delete-favorite="deleteFavorite" />
    <v-stepper v-else v-model="position" class="ma-4" vertical light>
      <v-stepper-step :complete="position > 3" step="3">
        身長
      </v-stepper-step>

      <v-stepper-content step="3">
        <MatchHeight ref="height" @click-height="inputHeight" @click-back="backContent" />
      </v-stepper-content>

      <v-stepper-step :complete="position > 4" step="4">
        体重
      </v-stepper-step>

      <v-stepper-content step="4">
        <MatchWeight ref="weight" @click-weight="inputWeight" @click-back="backContent" />
      </v-stepper-content>

      <v-stepper-step :complete="position > 5" step="5">
        性格
      </v-stepper-step>

      <v-stepper-content step="5">
        <MatchSalary ref="salary" @click-salary="inputSalary" @click-back="backContent" />
      </v-stepper-content>

      <v-stepper-step :complete="position > 6" step="6">
        顔のタイプ
      </v-stepper-step>

      <v-stepper-content step="6">
        <MatchFace ref="face" :sliderFaces="sliderFaces" @click-face="inputFace" @click-back="backContent" />
      </v-stepper-content>

      <v-stepper-step :complete="position > 7" step="7">
        好きな場所
      </v-stepper-step>

      <v-stepper-content step="7">
        <MatchPlace ref="place" @click-place="inputPlace" @click-back="backContent" />
      </v-stepper-content>
    </v-stepper>
  </div>
</template>

<script>
import diagnosis from '@/plugins/modules/diagnosis'
import favorite from '@/plugins/modules/favorite'
import DiagnosisCoice from '@/components/Diagnosis/Choice'
import DiagnosisResult from '@/components/Diagnosis/Result'
export default {
  auth: false,
  name: 'PagesMatch',
  components: {
    DiagnosisHeight,
    DiagnosisWeight,
    DiagnosisPlace,
    DiagnosisCoice,
    DiagnosisResult
  },
  data() {
    return {
      title: '犬診断',
      position: 1,
      choiceCount: 0,
      isError: false,
      isFilterError: false,
      errorMessage: null,
      isLoading: true,
      sex: null,
      age: null,
      height: null,
      weight: null,
      place: null,
      diagnosisResults: [],
    }
  },
  methods: {
    inputHeight(value) {
      if (value.length === 3) {
        this.height = value
        this.position = 4
        this.$refs.weight.focusInput()
      }
    },
    inputWeight(value) {
      if (value.length === 3) {
        this.weight = value
        this.position = 5
      }
    },
    inputPlace(value) {
      this.place = value
      diagnosis.result(this.sex, this.height, this.weight, this.age, this.salary, this.face, this.place).then((response) => {
        this.diagnosisResults.splice(0, response['result'].length)
        this.diagnosisResults.push(...response['result'])
        this.choiceFaces = response['choice']
        this.position = 8
      }).catch(() => {
      })
    },
    backContent(num) {
      if (num === 1) {
        this.$refs.sex.resetSex()
        this.position = num
      } else if (num === 2) {
        this.$refs.age.resetAge()
        this.position = num
      } else if (num === 3) {
        this.$refs.height.resetHeight()
        this.position = num
      } else if (num === 4) {
        this.$refs.weight.resetWeight()
        this.position = num
      } else if (num === 5) {
        this.$refs.salary.resetSalary()
        this.position = num
      } else if (num === 6) {
        this.$refs.face.resetFace()
        this.position = num
      } else if (num === 7) {
        this.$refs.place.resetPlace()
        this.position = num
      }
    },
    choiceLeft() {
      if (this.sex === 'male') {
        this.sexSort = 'female'
      } else {
        this.sexSort = 'male'
      }
      diagnosis.choice(this.choiceFaces[0].user_id, this.choiceFaces[1].user_id, this.sexSort).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceFaces = response
        }
      }).catch(() => {
      })
    },
    choiceRight() {
      if (this.sex === 'male') {
        this.sexSort = 'female'
      } else {
        this.sexSort = 'male'
      }
      diagnosis.choice(this.choiceFaces[1].user_id, this.choiceFaces[0].user_id, this.sexSort).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceFaces = response
        } else {
          this.position = 8
        }
      })
    },
    clickAlertLeft() {
      if (this.sex === 'male') {
        this.sexSort = 'female'
      } else {
        this.sexSort = 'male'
      }
      diagnosis.alert(this.choiceFaces[0].user_id, this.sexSort).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceFaces = response
        } else {
          this.position = 8
        }
      })
    },
    clickAlertRight() {
      if (this.sex === 'male') {
        this.sexSort = 'female'
      } else {
        this.sexSort = 'male'
      }
      diagnosis.alert(this.choiceFaces[1].user_id, this.sexSort).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceFaces = response
        } else {
          this.position = 8
        }
      })
    },
    addFavorite(friendId, index) {
      favorite.addFavorite(friendId).then(() => {
        this.diagnosisResults[index].onesideLove = 1
      })
    },
    deleteFavorite(friendId, index) {
      favorite.deleteFavorite(friendId).then(() => {
        this.diagnosisResults[index].onesideLove = 0
      })
    }
  }
}
</script>

<style scoped>
.all {
  text-align: center;
  max-width: 800px;
  min-width: 250px;
  margin-left: auto;
  margin-right: auto;
}

h1 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  margin: 20px;
}
</style>