<template>
  <div class="all">
    <h3 class="headline-dog pt-10">
      <PawsIcon class="paws-icon headline-text" />
      <span class="headline-text">飼い主さんの犬種診断</span>
    </h3>
    <diagnosis-choice
      v-if="choiceCount < 3 && position === 7"
      :leftDog="choiceDogs[0]"
      :rightDog="choiceDogs[1]"
      @choice-left="choiceLeft"
      @choice-right="choiceRight"
      @alert-left="clickAlertLeft"
      @alert-right="clickAlertRight"
    />
    <diagnosis-result
      v-else-if="position === 7" :diagnosisResult="diagnosisResult"
      @add-favorite="addFavorite"
      @delete-favorite="deleteFavorite"
    />
    <v-stepper v-else v-model="position" class="ma-4" light flat>
      <v-stepper-header>
        <v-stepper-step :complete="position > 1" step="1">
        </v-stepper-step>
        <v-divider></v-divider>
        <v-stepper-step :complete="position > 2" step="2">
        </v-stepper-step>
        <v-divider></v-divider>
        <v-stepper-step :complete="position > 3" step="3">
        </v-stepper-step>
        <v-divider></v-divider>
        <v-stepper-step :complete="position > 4" step="4">
        </v-stepper-step>
        <v-divider></v-divider>
        <v-stepper-step :complete="position > 5" step="5">
        </v-stepper-step>
        <v-divider></v-divider>
        <v-stepper-step :complete="position > 6" step="6">
        </v-stepper-step>
      </v-stepper-header>

      <v-stepper-items>
        <v-stepper-content step="1">
          <DiagnosisGender
            ref="gender"
            @click-gender="inputGender"
          />
        </v-stepper-content>
        <v-stepper-content step="2">
          <DiagnosisHeight
            ref="height"
            @click-height="inputHeight"
            @click-back="backContent"
          />
        </v-stepper-content>
        <v-stepper-content step="3">
          <DiagnosisWeight
            ref="weight"
            @click-weight="inputWeight"
            @click-back="backContent"
          />
        </v-stepper-content>
          <v-stepper-content step="4">
          <DiagnosisPersonality
            ref="personality"
            @click-personality="inputPersonality"
            @click-back="backContent"
          />
        </v-stepper-content>
        <v-stepper-content step="5">
          <DiagnosisFace
            ref="face"
            :gender="gender"
            @click-face="inputFace"
            @click-back="backContent"
          />
        </v-stepper-content>
        <v-stepper-content step="6">
          <DiagnosisHoliday
            ref="place"
            @click-holiday="inputHoliday"
            @click-back="backContent"
          />
        </v-stepper-content>
      </v-stepper-items>
    </v-stepper>
  </div>
</template>

<script>
import PawsIcon from "@/assets/image/svg/paws-icon.svg";
import diagnosis from '@/plugins/modules/diagnosis'
import favorite from '@/plugins/modules/favorite'
import DiagnosisGender from '@/components/Diagnosis/Gender'
import DiagnosisHeight from '@/components/Diagnosis/Height'
import DiagnosisWeight from '@/components/Diagnosis/Weight'
import DiagnosisPersonality from '@/components/Diagnosis/Personality'
import DiagnosisFace from '@/components/Diagnosis/Face'
import DiagnosisHoliday from '@/components/Diagnosis/Holiday'
import DiagnosisChoice from '@/components/Diagnosis/Choice'
import DiagnosisResult from '@/components/Diagnosis/Result'

export default {
  auth: false,
  name: 'PagesDiagnosis',
  components: {
    PawsIcon,
    DiagnosisGender,
    DiagnosisHeight,
    DiagnosisWeight,
    DiagnosisPersonality,
    DiagnosisFace,
    DiagnosisHoliday,
    DiagnosisChoice,
    DiagnosisResult
  },
  middleware: 'update_user_status',
  async asyncData({ query }) {
    let position = 1;
    let gender = null
    if (query.gender === 'male' || query.gender === 'female') {
      position = 2
      gender = query.gender
    }
    return {
      position,
      gender
    };
  },
  data () {
    return {
      title: 'あなたの犬種診断',
      position: 1,
      choiceCount: 0,
      isError: false,
      isFilterError: false,
      errorMessage: null,
      isLoading: true,
      gender: null,
      height: null,
      weight: null,
      personality1: null,
      personality2: null,
      personality3: null,
      face: null,
      holiday: null,
      diagnosisResult: [],
      choiceDogs: null
    }
  },
  methods: {
    inputGender (value) {
      this.gender = value
      this.position = 2
    },
    inputHeight (value) {
      if (value.length === 3) {
        this.height = value
        this.position = 3
        this.$refs.weight.focusInput()
      }
    },
    inputWeight (value) {
      if (value.length === 3) {
        this.weight = value
        this.position = 4
      }
    },
    inputPersonality (personality1, personality2, personality3) {
      this.personality1 = personality1
      this.personality2 = personality2
      this.personality3 = personality3
      this.position = 5
    },
    inputFace (value) {
      this.face = value
      this.position = 6
    },
    async inputHoliday (value) {
      this.holiday = value
      await diagnosis.result(
        this.gender,
        this.height,
        this.weight,
        this.personality1,
        this.personality2,
        this.personality3,
        this.face,
        this.holiday
      ).then((response) => {
        this.diagnosisResult = response['result']
        this.choiceDogs = response['choice']
        this.position = 7
      }).catch(() => {
      })
    },
    backContent (num) {
      if (num === 1) {
        this.position = num
      } else if (num === 2) {
        this.$refs.height.resetHeight()
        this.position = num
      } else if (num === 3) {
        this.$refs.weight.resetWeight()
        this.position = num
      } else if (num === 4) {
        this.$refs.personality.resetPersonality()
        this.position = num
      } else if (num === 5) {
        this.position = num
      } else if (num === 6) {
        this.position = num
      }
    },
    choiceLeft () {
      diagnosis.choice(this.choiceDogs[0].user_id, this.choiceDogs[1].user_id).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceDogs = response
        } else {
          this.position = 8
        }
      })
    },
    choiceRight () {
      diagnosis.choice(this.choiceDogs[1].user_id, this.choiceDogs[0].user_id).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceDogs = response
        } else {
          this.position = 8
        }
      })
    },
    clickAlertLeft () {
      diagnosis.alert(this.choiceDogs[0].user_id).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceDogs = response
        } else {
          this.position = 8
        }
      })
    },
    clickAlertRight () {
      diagnosis.alert(this.choiceDogs[1].user_id).then((response) => {
        if (this.choiceCount < 3) {
          this.choiceCount++
          this.choiceDogs = response
        } else {
          this.position = 8
        }
      })
    },
    addFavorite (friendId, index) {
      favorite.addFavorite(friendId).then(() => {
        this.diagnosisResults[index].onesideLove = 1
      })
    },
    deleteFavorite (friendId, index) {
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
  padding-left: 12px;
  padding-right: 12px;
  margin: 0 auto;
}

.headline-dog {
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: left;
  color: #505050;
}

.headline-text {
  vertical-align: middle;
}

.v-stepper__header {
  box-shadow: none !important;
}

@media screen and (min-width: 600px) {
  .all {
    padding-left: 40px;
    padding-right: 40px;
  }

  .headline-text {
    font-size: 1.5em;
  }

  .paws-icon {
    width: 1.5em;
    height: 1.5em;
  }
}
</style>