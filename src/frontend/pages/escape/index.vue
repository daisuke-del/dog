<template>
  <v-container>
    <!-- 💖 Heart to Skull Bar + Countdown -->
    <div class="skull-bar text-center my-4">
      <div v-if="skullCount < maxHearts">
        <span v-for="n in maxHearts" :key="n">
          <span v-if="n <= skullCount">💀</span>
          <span v-else>💖</span>
        </span>
        <div class="countdown mt-2">
          残り時間 {{ formattedTime }}
        </div>
      </div>
      <div v-else class="explosion">
        💣💥
      </div>
    </div>

    <v-stepper v-model="position">
      <v-stepper-header>
        <v-stepper-step :complete="finalUnlocked || position > 1" step="1">5つの試練</v-stepper-step>
        <v-stepper-step :complete="false" step="2" :editable="finalUnlocked">最終問題</v-stepper-step>
      </v-stepper-header>

      <v-stepper-items>
        <v-stepper-content step="1">
          <v-row>
            <v-col
              v-for="(problem, index) in problems"
              :key="problem.id"
              cols="12"
              md="6"
            >
            <ProblemPanel
              :problem="problem"
              :disabled="problem.solved"
              @solved="markSolved(index)"
              @failed="handleFailed"
            />
            </v-col>
          </v-row>
          <v-btn
            color="primary"
            :disabled="!finalUnlocked"
            @click="position = 2"
            class="mt-10"
          >
            最終問題に進む
          </v-btn>
        </v-stepper-content>

        <v-stepper-content step="2">
          <FinalProblem
            @failed="addSkull"
          />
        </v-stepper-content>
      </v-stepper-items>
    </v-stepper>

    <!-- ★ Special Challenge Section -->
    <v-card class="mt-12" outlined>
      <v-card-title>
        🌟 スペシャル謎解き回答フォーム
      </v-card-title>
      <v-card-text>
        <div v-if="!specialUnlocked">
          <v-text-field
            v-model="specialAnswer"
            label="回答を入力"
            outlined
          />
          <v-btn color="success" class="mt-2" @click="checkSpecialAnswer">
            確認
          </v-btn>
        </div>
        <div v-else>
          <v-alert type="success" outlined dense class="mb-4">
            正解です！検証フォームを使えるようになりました。
          </v-alert>

          <v-textarea
            v-model="testCode"
            label="PHPコード検証用"
            rows="6"
            auto-grow
            outlined
          />
          <v-btn color="primary" class="mt-2" @click="runTestCode" :loading="testing">
            実行
          </v-btn>
          <div class="mt-2">
            <strong>出力:</strong>
            <pre>{{ testOutput }}</pre>
          </div>
        </div>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import ProblemPanel from '~/components/Escape/ProblemPanel'
import FinalProblem from '~/components/Escape/FinalProblem'
import escape from '@/plugins/modules/escape'

export default {
  name: 'PagesEscape',
  auth: false,
  components: {
    ProblemPanel,
    FinalProblem
  },
  data () {
    return {
      position: 2,
      maxHearts: 3,
      skullCount: 0,
      explosionAudio: null,
      skullTimer: null,
      countdownTimer: null,
      timeLeft: 600,
      specialAnswer: '',
      specialUnlocked: false,
      testCode: '',
      testOutput: '',
      testing: false,
      correctAnswers: ['勝利', 'しょうり'],

      problems: [
        {
          id: 1,
          title: "変数",
          description: "変数 $a に 5 を代入し、それを2倍にして出力してください。",
          code: "$a = 5;",
          solved: false,
          structureErrors: []
        },
        {
          id: 2,
          title: "分岐処理",
          description: "$key が gold のときだけ「扉が開いた！」と表示してください。",
          code: "$key = 'gold';",
          solved: false,
          structureErrors: []
        },
        {
          id: 3,
          title: "繰り返し処理",
          description: "for 文を使って、「ランタン 1 点灯 ランタン 2 点灯 ランタン 3 点灯」と順番に出力してください。",
          code: "",
          solved: false,
          structureErrors: []
        },
        {
          id: 4,
          title: "配列",
          description: "foreach 文を使って、配列 [3, 5, 8] の合計値を出力してください。",
          code: "$nums = [3, 5, 8];",
          solved: false,
          structureErrors: []
        },
        {
          id: 5,
          title: "条件の組み合わせ",
          description: "分岐処理と繰り返し処理を用いて、1〜20の中から「偶数かつ5の倍数」の数字だけを出力してください。",
          code: "",
          solved: false,
          structureErrors: []
        }
      ],
      finalUnlocked: false
    }
  },
  computed: {
    formattedTime () {
      const m = Math.floor(this.timeLeft / 60).toString().padStart(2, '0')
      const s = (this.timeLeft % 60).toString().padStart(2, '0')
      return `${m}:${s}`
    }
  },
  mounted () {
    this.explosionAudio = new Audio('/sounds/explosion.mp3')
    this.skullTimer = setInterval(() => {
      if (this.skullCount < this.maxHearts) {
        this.skullCount++
        this.timeLeft = 600
      }
    }, 10 * 60 * 1000)

    this.countdownTimer = setInterval(() => {
      if (this.timeLeft > 0) {
        this.timeLeft--
      }
    }, 1000)
  },
  beforeDestroy () {
    clearInterval(this.skullTimer)
    clearInterval(this.countdownTimer)
  },
  watch: {
    skullCount (val) {
      if (val >= this.maxHearts) {
        this.triggerExplosion()
      }
    }
  },
  methods: {
    markSolved(index) {
      this.$set(this.problems[index], 'solved', true)
      this.$set(this.problems[index], 'structureErrors', [])
      this.maxHearts += 2 // 正解でハート2つ増える
      if (this.problems.every(p => p.solved)) {
        this.finalUnlocked = true
      }
    },
    handleFailed({ id, structureErrors }) {
      const problem = this.problems.find(p => p.id === id)
      this.$set(problem, 'structureErrors', structureErrors)
      this.addSkull()
    },
    addSkull () {
      if (this.skullCount < this.maxHearts) {
        this.skullCount++
      }
    },
    triggerExplosion () {
      if (this.explosionAudio) {
        this.explosionAudio.play()
      }
      setTimeout(() => {
        this.$router.push('/escape/gameover')
      }, 2000)
    },
    checkSpecialAnswer () {
      if (this.correctAnswers.includes(this.specialAnswer.trim().toLowerCase())) {
        this.specialUnlocked = true
      } else {
        alert('不正解です')
      }
    },
    async runTestCode () {
      this.testing = true
      this.testOutput = ''
      try {
        const res = await escape.runCode(10, this.testCode)
        this.testOutput = res.output
      } catch (e) {
        this.testOutput = e.response?.data?.error || 'エラーが発生しました'
      }
      this.testing = false
    }
  }
}
</script>

<style scoped>
.skull-bar span {
  font-size: 24px;
  margin: 0 2px;
}
.countdown {
  font-size: 16px;
  color: #555;
  margin-top: 4px;
}
.explosion {
  font-size: 48px;
  animation: explode 0.3s ease-in-out infinite alternate;
}
@keyframes explode {
  0% { transform: scale(1); }
  100% { transform: scale(1.3) rotate(5deg); }
}
</style>
