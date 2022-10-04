<template>
  <div>
    <h2>マッチング診断</h2>
    <v-stepper v-model="position" class="ma-4" vertical light>
        <v-stepper-step
          :complete="position > 1"
          step="1"
        >
          性別
        </v-stepper-step>

        <v-stepper-content step="1">
          <MatchGender
            @click="genderClick"
          />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 2"
          step="2"
        >
          年齢
        </v-stepper-step>

        <v-stepper-content step="2">
          <MatchAge />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 3"
          step="3"
        >
          身長
        </v-stepper-step>

        <v-stepper-content step="3">
          <MatchHeight />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 4"
          step="4"
        >
          体重
        </v-stepper-step>

        <v-stepper-content step="4">
          <MatchWeight />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 5"
          step="5"
        >
          年収
        </v-stepper-step>

        <v-stepper-content step="5">
          <MatchSalary />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 6"
          step="6"
        >
          顔
        </v-stepper-step>

        <v-stepper-content step="6">
          <MatchFace />
        </v-stepper-content>

        <v-stepper-step
          :complete="position > 7"
          step="7"
        >
          出会う場所
        </v-stepper-step>

        <v-stepper-content step="7">
          <MatchPlace />
        </v-stepper-content>
    </v-stepper>
  </div>
</template>

<script>
import MatchGender from '~/components/Match/Gender'
import MatchAge from '~/components/Match/Age'
import match from '~/plugins/modules/match'
export default {
  name: 'PagesMatch',
  components: {
    MatchGender,
    MatchAge
  },
  data () {
    return {
      position: 1,
      url: 'http://127.0.0.1:8000/api/',
    }
  },
  methods: {
    clickGender(gender){
      const url = this.url + 'match/gender'
      axios.post(url, {
        gender,
      }).then(response => {
            console.log(response.data)
          }
      )
    }
  }
}
</script>

<style scoped>
h2 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
}
</style>