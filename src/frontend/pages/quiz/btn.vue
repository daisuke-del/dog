<template>
  <v-card class="pa-4" outlined>
    <v-card-title>
      🔔 早押しクイズルーム：{{ roomCode || '未参加' }}
    </v-card-title>

    <v-card-text>
      <div v-if="!roomJoined">
        <v-text-field v-model="playerName" label="名前を入力" outlined dense />
        <v-text-field v-model="inputRoom" label="ルームコードを入力" outlined dense />
        <v-btn color="primary" @click="joinRoom" :disabled="!playerName || !inputRoom">ルームに入る</v-btn>
      </div>

      <div v-else>
        <v-tabs v-model="tab">
          <v-tab>プレイヤー画面</v-tab>
          <v-tab>出題者画面</v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
          <!-- プレイヤー画面 -->
          <v-tab-item>
            <v-row>
              <v-col cols="12">
                <v-btn :disabled="hasPressed" @click="buzz" color="red" x-large class="mt-2">
                  押す！
                </v-btn>
              </v-col>

              <v-col cols="12">
                <h4>順番（上が先）:</h4>
                <ol>
                  <li
                    v-for="(p, index) in pressedQueue.slice(0, 3)"
                    :key="p"
                    :class="{ highlight: index === 0 }"
                  >
                    {{ index === 0 ? '🎤' : '' }} {{ p }}（{{ scores[p] || 0 }}P）
                  </li>
                </ol>
              </v-col>
            </v-row>
          </v-tab-item>

          <!-- 出題者画面 -->
          <v-tab-item>
            <div v-if="pressedQueue.length > 0">
              <v-btn color="success" class="mr-2" @click="markCorrect">正解</v-btn>
              <v-btn color="error" @click="markWrong">不正解</v-btn>
            </div>
            <v-btn class="mt-4" color="orange" @click="playQuestion">
              出題（音を鳴らす）
            </v-btn>
            <v-btn class="mt-4 ml-2" @click="resetRound" color="blue">
              次の問題へ（リセット）
            </v-btn>

            <v-divider class="my-4" />

            <h4>順番（上が先）:</h4>
            <ol>
              <li
                v-for="(p, index) in pressedQueue.slice(0, 3)"
                :key="p"
                :class="{ highlight: index === 0 }"
              >
                {{ index === 0 ? '🎤' : '' }} {{ p }}（{{ scores[p] || 0 }}P）
              </li>
            </ol>

            <v-divider class="my-4" />

            <h4>現在のスコア：</h4>
            <ul>
              <li v-for="(score, name) in scores" :key="name">{{ name }}：{{ score }}P</li>
            </ul>
          </v-tab-item>

        </v-tabs-items>
      </div>
    </v-card-text>
  </v-card>
</template>

<script>
import { io } from 'socket.io-client'

export default {
  auth: false,
  name: 'QuizBuzzButton',
  data () {
    return {
      playerName: '',
      inputRoom: '',
      roomCode: '',
      roomJoined: false,
      tab: 0,
      pressedQueue: [],
      scores: {},
      hasPressed: false,
      socket: null,
      buzzSound: null,
      correctSound: null,
      wrongSound: null,
      questionSound: null
    }
  },
  mounted () {
    const socketUrl = process.env.WS_URL
    this.socket = io(socketUrl, {
      path: '/socket.io/',
      transports: ['websocket']
    })
    this.socket.on('state', (state) => {
      this.pressedQueue = state.pressedQueue
      this.scores = state.scores
      localStorage.setItem('scores', JSON.stringify(state.scores))
    })

    const savedScores = localStorage.getItem('scores')
    if (savedScores) {
      this.scores = JSON.parse(savedScores)
    }

    this.buzzSound = new Audio('/sounds/buzz.mp3')
    this.correctSound = new Audio('/sounds/correct.mp3')
    this.wrongSound = new Audio('/sounds/wrong.mp3')
    this.questionSound = new Audio('/sounds/question.mp3')
  },
  methods: {
    joinRoom () {
      this.roomCode = this.inputRoom.trim()
      this.roomJoined = true
      this.hasPressed = false
      this.socket.emit('join', {
        room: this.roomCode,
        name: this.playerName
      })
    },
    buzz () {
      if (!this.playerName || this.hasPressed) return
      this.hasPressed = true
      this.socket.emit('buzz')
      if (this.buzzSound) this.buzzSound.play()
    },
    markCorrect () {
      if (this.correctSound) this.correctSound.play()
      this.socket.emit('correct')
      this.resetRound()
    },
    markWrong () {
      if (this.wrongSound) this.wrongSound.play()
      this.socket.emit('wrong')
      // Remove first player from queue
      if (this.pressedQueue.length > 0) {
        this.pressedQueue.shift()
      }
    },
    resetRound () {
      this.socket.emit('reset')
      this.hasPressed = false
    },
    playQuestion () {
      if (this.questionSound) this.questionSound.play()
    }
  }
}
</script>

<style scoped>
ol {
  padding-left: 1.2rem;
}
li {
  margin-bottom: 4px;
}
.highlight {
  font-weight: bold;
  color: #4caf50;
  background: #e8f5e9;
  border-radius: 4px;
  padding: 4px;
}
</style>
