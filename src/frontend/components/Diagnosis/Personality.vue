<template>
    <div class="all">
      <p class="big-text d-flex justify-center">あなたの性格を分析</p>
      <div>
        <div class="slider d-flex pt-10">
          <p>元　気</p>
          <v-slider
            v-model="personality1.val"
            :thumb-color="personality1.color"
            track-color="primary"
            thumb-label="always"
            hide-details
          />
          <p>穏やか</p>
        </div>
        <div class="slider d-flex">
          <p>自　由</p>
          <v-slider
            v-model="personality2.val"
            :thumb-color="personality2.color"
            track-color="primary"
            thumb-label="always"
            hide-details
          />
          <p>真面目</p>
        </div>
        <div class="slider d-flex">
          <p>内向的</p>
          <v-slider
            v-model="personality3.val"
            :thumb-color="personality3.color"
            track-color="primary"
            thumb-label="always"
            hide-details
          />
          <p>外向的</p>
        </div>
      </div>
      <div class="btn-wrap">
        <button
          class="btn"
          @click="clickBack()"
        >
          戻る
        </button>
        <button
          class="btn"
          @click="clickPersonality()"
        >
          次へ
        </button>
      </div>
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
    font-size: 1.3em;
    font-family: 'Noto Sans JP', sans-serif;
    color: slategray;
  }

  .btn-wrap {
    text-align: center;
  }

  .btn {
    font-family: 'Noto Sans JP', sans-serif;
    font-size: 1em;
    color: slategray;
    background-color: white;
    width: 100px;
    height: 30px;
    border-radius: .3em;
    outline: 1px solid #B9C9CE;
    margin: 20px 17px 5px 0;
  }

  .back-btn:hover {
    outline: none;
    border: 2px solid #B9C9CE;
  }

  @media screen and (min-width: 600px) {
    .big-text {
      font-size: 2.3em;
    }

    .btn {
      font-size: 1.5em;
      width: 200px;
      height: 50px;
    }

    .btn-wrap {
      margin-top: 30px;
      margin-right: 30px;
    }
  }
  </style>