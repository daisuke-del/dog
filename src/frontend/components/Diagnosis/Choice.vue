<template>
  <div class="all">
    <p class="big-text d-flex justify-center">可愛い方を選ぼう！</p>
    <div class="card-wrap d-flex justify-center">
      <div>
        <v-card
          light
          hover
          :class="isDiagnosis ? 'card' : 'card2'"
          @click="choiceLeft"
        >
          <v-img :src="getImageUrl(leftDog.dog_image1)" />
        </v-card>
      </div>
      <div>
        <v-card
          light
          hover
          :class="isDiagnosis ? 'card' : 'card2'"
          @click="choiceRight"
        >
          <v-img :src="getImageUrl(rightDog.dog_image1)" />
        </v-card>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'DiagnosisChoice',
    props: {
      leftDog: {
        type: Object,
        required: false
      },
      rightDog: {
        type: Object,
        required: false
      },
      isDiagnosis: {
        type: Boolean,
        default: true
      }
    },
    data () {
      return {
        isLeft: false,
      }
    },
    methods: {
      choiceLeft () {
        this.$emit('choice-left')
      },
      choiceRight () {
        this.$emit('choice-right')
      },
      getImageUrl(image) {
        if (!image) {
          image = '1.jpg';
        }
        return `${process.env.imageBaseUrl}/${image}`;
      },
    }
  }
</script>
<style scoped>
.big-text {
  margin-top: 50px;
  font-size: 1.2em;
  color: #505050;
  font-weight: bold;
}

.card-wrap {
  text-align: center;
  align-items: center;
  margin: 20px;
}

.card {
  display: inline-block;
  max-width: 250px;
  margin: 20px;
  position: relative;
}

.card2 {
  display: inline-block;
  max-width: 150px;
  margin: 20px;
  position: relative;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 1.8em;
  }
}

@media screen and (max-width: 600px) {
  .card {
    max-width: 150px;
    margin: 10px;
  }

  .card2 {
    max-width: 100px;
    margin: 10px;
  }
}
</style>
