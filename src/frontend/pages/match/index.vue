<template>
  <div class="all">
    <h1>{{ title }}</h1>
    <match-result
      v-if="choiceCount < 3"
      :matchResults="matchResults"
    />
    <match-choice
      v-else-if="position === 8"
      :leftImage="choiceFaces[0]"
      :rightImage="choiceFaces[1]"
      @choice-left="choiceLeft"
      @choice-right="choiceRight"
      @alert-left="clickAlertLeft"
      @alert-right="clickAlertRight"
    />
    <v-stepper
      v-else
      v-model="position"
      class="ma-4"
      vertical
      light
    >
        <v-stepper-step
          :complete="position > 1"
          step="1"
        >
          性別
        </v-stepper-step>

        <v-stepper-content step="1">
          <MatchGender
            ref="gender"
            @click-gender="inputGender"
          />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 2"
          step="2"
        >
          年齢
        </v-stepper-step>

        <v-stepper-content step="2">
          <MatchAge
            ref="age"
            @click-age="inputAge"
            @click-back="backContent"
          />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 3"
          step="3"
        >
          身長
        </v-stepper-step>

        <v-stepper-content step="3">
          <MatchHeight
            ref="height"
            @click-height="inputHeight"
            @click-back="backContent"
          />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 4"
          step="4"
        >
          体重
        </v-stepper-step>

        <v-stepper-content step="4">
          <MatchWeight
            ref="weight"
            @click-weight="inputWeight"
            @click-back="backContent"
          />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 5"
          step="5"
        >
          年収
        </v-stepper-step>

        <v-stepper-content step="5">
          <MatchSalary
            ref="salary"
            @click-salary="inputSalary"
            @click-back="backContent"
          />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 6"
          step="6"
        >
          顔
        </v-stepper-step>

        <v-stepper-content step="6">
          <MatchFace
            ref="face"
            :sliderFaces="sliderFaces"
            @click-face="inputFace"
            @click-back="backContent"
          />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 7"
          step="7"
        >
          出会い
        </v-stepper-step>

        <v-stepper-content step="7">
          <MatchPlace
            ref="place"
            @click-place="inputPlace"
            @click-back="backContent"
          />
        </v-stepper-content>
    </v-stepper>
  </div>
</template>

<script>
import slider from '@/plugins/modules/slider'
import match from '@/plugins/modules/match'
import MatchGender from '@/components/Match/Gender'
import MatchAge from '@/components/Match/Age'
import MatchHeight from '@/components/Match/Height'
import MatchWeight from '@/components/Match/Weight'
import MatchSalary from '@/components/Match/Salary'
import MatchFace from '@/components/Match/Face'
import MatchPlace from '@/components/Match/Place'
import MatchCoice from '@/components/Match/Choice'
import MatchResult from '@/components/Match/Result'
import slider from '@/plugins/modules/slider'
export default {
  auth: false,
  name: 'PagesMatch',
  components: {
    MatchGender,
    MatchAge,
    MatchHeight,
    MatchWeight,
    MatchSalary,
    MatchFace,
    MatchPlace,
    MatchCoice,
    MatchResult
  },
  data () {
    return {
      title: 'マッチング診断',
      position: 1,
      choiceCount: 0,
      isError: false,
      isFilterError: false,
      errorMessage: null,
      isLoading: true,
      gender: null,
      age: null,
      height: null,
      weight: null,
      salary: null,
      face: null,
      place: null,
      sliderFaces: [
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0},
        { faceImage: '0.jpeg', facePint: 0}
      ],
      choiceFaces: [],
      matchResults: []
    }
  },
  methods: {
    inputGender (value) {
      this.gender = value
      slider.getFace(this.gender).then((respose) => {
        this.sliderFaces = respose
      })
      this.position = 2
      this.$refs.age.focusInput()
    },
    inputAge (value) {
      if (value.length === 3) {
        this.age = value
        this.position = 3
        this.$refs.height.focusInput()
      }
    },
    inputHeight (value) {
      if (value.length === 3) {
        this.height = value
        this.position = 4
        this.$refs.weight.focusInput()
      }
    },
    inputWeight (value) {
      if (value.length === 3) {
        this.weight = value
        this.position = 5
      }
    },
    inputSalary (value) {
      this.salary = value
      this.position = 6
    },
    inputFace (value) {
      this.face = value
      this.position = 7
    },
    inputPlace (value) {
      this.place = value
      this.$store.dispatch('match/setMatch', {
        gender: this.gender,
        age: this.age,
        height: this.height,
        weight: this.weight,
        salary: this.salary,
        face: this.face,
        place: this.place
      })
      match.result.then((respose) => {
        this.matchResults = respose.data
        console.log(respose)
      }).catch((error) => {
        console.log(error)
      })
      this.position = 8
    },
    backContent (num) {
      if (num === 1) {
        this.$refs.gender.resetGender()
        this.transitionContent (num)
      } else if (num === 2) {
        this.$refs.age.resetAge()
        this.transitionContent (num)
      } else if (num === 3) {
        this.$refs.height.resetHeight()
        this.transitionContent (num)
      } else if (num === 4) {
        this.$refs.weight.resetWeight()
        this.transitionContent (num)
      } else if (num === 5) {
        this.$refs.salary.resetSalary()
        this.transitionContent (num)
      } else if (num === 6) {
        this.$refs.face.resetFace()
        this.transitionContent (num)
      } else if (num === 7) {
        this.$refs.place.resetPlace()
        this.transitionContent (num)
      }
    },
    choiceLeft () {
      if (this.gender === 'male') {
        const gender = 'female'
      } else {
        const gender = 'male'
      }
      match.choice(this.choiceFaces[0].userId, this.choiceFaces[1].userId, gender).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount ++
          this.choiceFaces = response
        } else {
          this.position = 8
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    choiceRight () {
      if (this.gender === 'male') {
        const gender = 'female'
      } else {
        const gender = 'male'
      }
      match.choice(this.choiceFaces[1].userId, this.choiceFaces[0].userId, gender).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount ++
          this.choiceFaces = response
        } else {
          this.position = 8
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    clickAlertLeft () {
      if (this.gender === 'male') {
        const gender = 'female'
      } else {
        const gender = 'male'
      }
      match.alert(this.choiceFaces[0].userId, gender).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount ++
          this.choiceFaces = response
        } else {
          this.position = 8
        }
      }).catch((error) => {
        console.log(error)
      })
    },
    clickAlertRight () {
      if (this.gender === 'male') {
        const gender = 'female'
      } else {
        const gender = 'male'
      }
      match.alert(this.choiceFaces[1].userId, gender).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount ++
          this.choiceFaces = response
        } else {
          this.position = 8
        }
      }).catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>

<style scoped>
.all {
  text-align: center;
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
}

h1 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  margin: 20px;
}
</style>