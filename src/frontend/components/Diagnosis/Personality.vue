<template>
    <div class="all">
      <p class="big-text d-flex justify-center">あなたの性格</p>
      <div>
        <div class="slider d-flex pt-10">
          <p>元　気</p>
          <v-slider
            v-model="personality1.val"
            track-color="primary"
            hide-details
          />
          <p>穏やか</p>
        </div>
        <div class="slider d-flex">
          <p>自　由</p>
          <v-slider
            v-model="personality2.val"
            track-color="primary"
            hide-details
          />
          <p>真面目</p>
        </div>
        <div class="slider d-flex">
          <p>内向的</p>
          <v-slider
            v-model="personality3.val"
            track-color="primary"
            hide-details
          />
          <p>外向的</p>
        </div>
      </div>
      <v-btn
        text
        :x-large="$vuetify.breakpoint.smAndUp"
        color="primary"
        @click="clickBack()"
        class="mt-4"
      >
        戻る
      </v-btn>
      <v-btn
        :x-large="$vuetify.breakpoint.smAndUp"
        color="primary"
        @click="clickPersonality()"
        class="mt-4"
      >
        次へ
      </v-btn>
    </div>
  </template>

  <script>
  export default {
    name: 'DiagnosisPersonality',
    data () {
      return {
        inputPersonality1: 50,
        inputPersonality2: 50,
        inputPersonality3: 50,
        personality1: { label: 'thumb-color', val: 50, color: 'red' },
        personality2: { label: 'thumb-color', val: 50, color: 'blue' },
        personality3: { label: 'thumb-color', val: 50, color: 'green' },
      }
    },
    methods: {
      clickPersonality () {
        this.$emit('click-personality', this.inputPersonality1, this.inputPersonality2, this.inputPersonality3)
      },
      clickBack () {
        this.$emit('click-back', 3)
      },
      resetPersonality () {
        this.inputPersonality1 = 50
        this.inputPersonality2 = 50
        this.inputPersonality3 = 50
      },
    }
  }
  </script>

  <style scoped>
  .all {
    margin-right: 20px;
  }

  .slider {
    max-width: 500px;
    margin: 0 auto;
    padding-bottom: 50px;
  }

  .slider p {
    margin: 0;
  }

  .big-text {
    font-size: 1.2em;
    color: #505050;
    font-weight: bold;
  }

  @media screen and (min-width: 600px) {
    .big-text {
      font-size: 1.8em;
      color: #505050;
    }
  }
  </style>