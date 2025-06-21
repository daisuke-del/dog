<template>
  <v-container class="text-center">
    <!-- 🎉 イントロ画面 -->
    <div v-if="step === 'intro'" class="intro-screen">
      <h1 class="display-1 font-weight-bold mb-5">恋愛診断 AIマッチング</h1>
      <p class="mb-5">あなたにぴったりの相手を<br>81億人の中から探し出します。</p>
      <v-btn color="deep-purple accent-4" dark large @click="step = 'gender'">
        81億分の1を探す
      </v-btn>
    </div>

    <!-- 性別選択 -->
    <div v-else-if="step === 'gender'" class="question-screen d-flex flex-column justify-center align-center">
      <h2>あなたの性別を教えてください</h2>
      <div class="d-flex justify-center flex-wrap mt-4">
        <v-btn color="blue" class="mx-2" @click="selectGender('male')">男性</v-btn>
        <v-btn color="pink" class="mx-2" @click="selectGender('female')">女性</v-btn>
      </div>
    </div>

    <!-- 質問 -->
    <div v-else-if="step === 'question'" class="question-screen d-flex flex-column justify-center align-center">
      <h2>{{ categoryLabels[currentCategory] }}</h2>
      <p>{{ currentQuestionText }}</p>
      <div class="d-flex justify-center flex-wrap mt-4">
        <v-btn color="green" class="mx-2" @click="answer(true)">はい</v-btn>
        <v-btn color="grey" class="mx-2" @click="answer(false)">いいえ</v-btn>
      </div>
    </div>

    <!-- Yes回答表示 -->
    <div v-else-if="step === 'reveal'">
      <div
        v-for="(item, index) in revealedQuestions"
        :key="index"
        class="reveal-line d-flex flex-wrap justify-center align-center my-4"
      >
        <span class="mr-2 question-text">{{ item.text }}</span>
        <img
          v-if="item.showStamp"
          src="@/assets/image/diagnosis/yes_stamp.png"
          alt="YESスタンプ"
          class="yes-stamp-img mx-1"
        />
      </div>
    </div>

    <!-- マッチング結果 -->
    <div v-else-if="step === 'result'">
      <transition name="fade-smooth">
        <div v-if="person" class="d-flex flex-column align-center justify-center">
          <v-img
            :src="person.image"
            class="my-5 person-image"
            contain
            max-height="300"
          />
        </div>
      </transition>

      <transition name="fade-smooth" appear>
        <div v-if="person" class="mt-3">
          <h2>{{ person.name }} さんとマッチング！</h2>
          <p>{{ person.comment }}</p>
        </div>
      </transition>
    </div>


    <!-- ローディング -->
    <div v-else-if="step === 'loading'">
      <p>診断中...</p>
    </div>
  </v-container>
</template>

<script>
export default {
  auth: false,
  data() {
    return {
      step: 'intro',
      gender: null,
      currentCategoryIndex: 0,
      currentQuestionIndex: 0,
      matchedQuestions: [],
      revealedQuestions: [],
      person: null,
      personReady: false,
      categoryOrder: ['appearance', 'personality', 'social', 'love', 'marriage'],
      categoryLabels: {
        appearance: '見た目について',
        personality: '性格について',
        social: '人との付き合い方について',
        love: '恋愛観について',
        marriage: '結婚観について'
      },
      questions: {},
      questionsByGender: {
        male: {
          appearance: [
            '短髪でさっぱりした見た目って好感が持てる？',
            'ラフな服装の人に親近感を覚える？',
            '運動が得意そうな人に惹かれることがある？'
          ],
          personality: [
            '落ち着いていて大人っぽい人って素敵だと思う？',
            '言葉数は少ないけど信頼できそうな人に惹かれる？',
            'どちらかというとクールなタイプが気になる？'
          ],
          social: [
            '一緒にいて気を使わない相手に安心する？',
            '少人数の人付き合いが好きなタイプに共感できる？',
            '口数は少なくてもちゃんと気配りしてくれる人が好き？'
          ],
          love: [
            '恋愛はゆっくり進めたいと思う？',
            '控えめな好意にキュンとすることがある？',
            '恋愛でガツガツ来られるより、自然な距離感が好き？'
          ],
          marriage: [
            'ずっと一緒にいても疲れない相手が理想？',
            '言葉が少なくても通じ合える関係に憧れる？',
            '結婚相手には落ち着きを求める？'
          ]
        },
        female: {
          appearance: [
            '髪型やファッションにこだわる人に惹かれる？',
            '柔らかい雰囲気の見た目が好き？',
            '背が高くて落ち着いた雰囲気の人がタイプ？'
          ],
          personality: [
            '明るくて元気な性格の人に惹かれる？',
            '感情表現が豊かで親しみやすい人が好き？',
            '優柔不断よりも決断力のある人がいい？'
          ],
          social: [
            '誰とでもすぐ仲良くなれる人に好感を持つ？',
            'グループの中心にいるタイプに惹かれる？',
            '話し上手な人と一緒にいると楽しい？'
          ],
          love: [
            '恋愛にはドキドキ感が欲しい？',
            '好きな人とは毎日連絡を取りたい？',
            '自分からアプローチすることが多い？'
          ],
          marriage: [
            '家庭的で子ども好きな人に安心する？',
            'パートナーとなんでも共有したいと思う？',
            '結婚後も恋人のような関係でいたい？'
          ]
        }
      }
    }
  },
  computed: {
    currentCategory() {
      return this.categoryOrder[this.currentCategoryIndex]
    },
    currentQuestionText() {
      return this.questions[this.currentCategory][this.currentQuestionIndex]
    }
  },
  methods: {
    selectGender(g) {
      this.gender = g
      this.questions = this.questionsByGender[g]
      this.step = 'question'
    },
    answer(isYes) {
      const currentQ = this.questions[this.currentCategory][this.currentQuestionIndex]
      if (isYes) {
        this.matchedQuestions.push(currentQ)
        this.nextCategory()
      } else {
        this.currentQuestionIndex++
        if (this.currentQuestionIndex >= 3) {
          this.nextCategory()
        }
      }
    },
    nextCategory() {
      this.currentCategoryIndex++
      this.currentQuestionIndex = 0
      if (this.currentCategoryIndex >= this.categoryOrder.length) {
        this.finishDiagnosis()
      }
    },
    async finishDiagnosis() {
      this.step = 'loading'
      await this.revealYesQuestions()

      try {
        const id = this.$route.params.id
        const res = await this.$axios.$get('/api/diagnosis/person/' + id)
        this.person = res
      } catch (e) {
        this.person = null
      }

      this.step = 'result'
      await this.delay(300) // ← ふんわり感のための一拍
      this.personReady = true
    },
    async revealYesQuestions() {
      this.revealedQuestions = []
      this.step = 'reveal'

      const totalCount = Math.min(this.matchedQuestions.length, 5)
      for (let i = 0; i < totalCount; i++) {
        let revealed = ''
        const question = this.matchedQuestions[i]
        this.revealedQuestions.push({ text: '', showStamp: false })

        for (let j = 0; j < question.length; j++) {
          revealed += question[j]
          this.$set(this.revealedQuestions, i, {
            text: revealed,
            showStamp: false
          })
          await this.delay(60)
        }

        this.$set(this.revealedQuestions, i, {
          text: revealed,
          showStamp: true
        })

        await this.delay(400)
      }
    },
    delay(ms) {
      return new Promise(resolve => setTimeout(resolve, ms))
    }
  },
  head() {
    const id = this.$route.params.id

    return {
      title: '恋愛診断 - 80億分の1の奇跡',
      meta: [
        { hid: 'description', name: 'description', content: 'あなたの恋愛傾向を診断し、最適な相手をマッチング！' },
        { hid: 'og:type', property: 'og:type', content: 'website' },
        { hid: 'og:title', property: 'og:title', content: '恋愛診断でマッチング相手をチェック！' },
        { hid: 'og:description', property: 'og:description', content: '恋愛観・性格・見た目から相性診断！今すぐチェック！' },
        { hid: 'og:url', property: 'og:url', content: `https://www.dogiland.jp/diagnosis/love/${id}` },
        { hid: 'twitter:card', name: 'twitter:card', content: 'summary_large_image' },
        { hid: 'twitter:title', name: 'twitter:title', content: '恋愛診断で相性ぴったりの相手を発見！' },
        { hid: 'twitter:description', name: 'twitter:description', content: 'あなたの恋愛傾向にぴったりの人は？今すぐ診断しよう！' },
        { hid: 'twitter:image', name: 'twitter:image', content: `https://www.dogiland.jp/storage/love/ogp/${id}.jpg` }
      ]
    }
  }
}
</script>

<style scoped>
.intro-screen {
  padding-top: 80px;
}
.intro-screen h1 {
  font-size: 2.8rem;
}
.intro-screen p {
  font-size: 1.4rem;
  color: #555;
}

.reveal-line {
  font-size: 1.2rem;
  font-weight: bold;
  flex-wrap: wrap;
}
.question-text {
  display: inline-block;
  max-width: 100%;
  word-break: break-word;
  text-align: center;
}
.yes-stamp-img {
  width: 36px;
  height: auto;
}

@media (max-width: 600px) {
  .reveal-line {
    flex-direction: column;
    text-align: center;
    font-size: 1rem;
  }
  .yes-stamp-img {
    width: 30px;
    margin: 4px;
  }

  .intro-screen h1 {
    font-size: 2.2rem;
  }

  .intro-screen p {
    font-size: 1.1rem;
  }

  .reveal-line {
    font-size: 0.96rem; /* 1.2rem → 約8割 */
  }

  .question-text {
    font-size: 0.9rem;
  }

  h2 {
    font-size: 1.2rem;
  }

  p {
    font-size: 0.9rem;
  }

  .person-image + h2 {
    font-size: 1.3rem;
  }

  .person-image + h2 + p {
    font-size: 1rem;
  }
}

.fade-smooth-enter-active {
  transition: opacity 2s ease, transform 2s ease;
}
.fade-smooth-leave-active {
  transition: opacity 1s ease;
}
.fade-smooth-enter {
  opacity: 0;
  transform: scale(1.05);
}
.fade-smooth-leave-to {
  opacity: 0;
  transform: scale(1.05);
}

.question-screen {
  min-height: 80vh; /* 画面高の80%を占めるようにして中央寄せ */
}

.person-image {
  max-width: 100%;
  width: auto;
  height: auto;
  margin: 0 auto;
  object-fit: contain;
}

@media (max-width: 600px) {
  .question-screen .v-btn {
    min-width: 100px;
    font-size: 0.85rem;
  }
}

.fade-smooth-enter-active {
  transition: opacity 1.5s ease, transform 1.5s ease;
}
.fade-smooth-leave-active {
  transition: opacity 0.8s ease;
}
.fade-smooth-enter {
  opacity: 0;
  transform: translateY(10px);
}
.fade-smooth-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
