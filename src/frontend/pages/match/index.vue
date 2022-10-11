<template>
  <div class="all">
    <h2>{{ title }}</h2>
    <v-stepper v-model="position" class="ma-4" vertical light>
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
import { mapGetters } from 'vuex'
import MatchGender from '~/components/Match/Gender'
import MatchAge from '~/components/Match/Age'
import MatchHeight from '~/components/Match/Height'
import MatchWeight from '~/components/Match/Weight'
import MatchSalary from '~/components/Match/Salary'
import MatchFace from '~/components/Match/Face'
import MatchPlace from '~/components/Match/Place'
export default {
  name: 'PagesMatch',
  components: {
    MatchGender,
    MatchAge,
    MatchHeight,
    MatchWeight,
    MatchSalary,
    MatchFace,
    MatchPlace
  },
  data () {
    return {
      title: 'マッチング診断',
      position: 1,
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
    }
  },
  methods: {
    inputGender (value) {
      this.gender = value
      this.transitionContent(2)
      this.$refs.age.focusInput()
    },
    inputAge (value) {
      if (value.length === 2) {
        this.age = value
        this.transitionContent(3)
        this.$refs.height.focusInput()
      }
    },
    inputHeight (value) {
      if (value.length === 3) {
        this.height = value
        this.transitionContent(4)
        this.$refs.weight.focusInput()
      }
    },
    inputWeight (value) {
      if (value.length === 3) {
        this.weight = value
        this.transitionContent(5)
      }
    },
    inputSalary (value) {
      this.salary = value
      this.transitionContent(6)
    },
    inputFace (value) {
      this.face = value
      this.transitionContent(7)
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
    },
    transitionContent (num) {
      this.position = num
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
    }
  },
  computed: {
    ...mapGetters(['match/match'])
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

h2 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  margin: 20px;
}
</style>