<template>
  <v-card>
    <v-card-title>
      🔐 最終問題：脱出コードを導き出せ！
    </v-card-title>

    <v-card-text>
      <p>
        1から2000までの数字のうち、<strong>13の倍数</strong>をすべて<strong>逆順に連結して</strong>出力してください。<br>
        例：<code>1989197619...</code><br>
        出力が正しければ、脱出成功です！
      </p>

      <v-textarea
        v-model="code"
        label="ここにPHPコードを入力"
        outlined
        rows="8"
        auto-grow
      />

      <v-btn color="deep-purple accent-4" dark class="mt-4" @click="runCode" :loading="loading">
        実行して脱出！
      </v-btn>

      <div class="mt-4">
        <div><strong>出力:</strong></div>
        <pre>{{ output.length > 120 ? output.substr(0, 100) + ' ... ' + output.slice(-10) : output }}</pre>
      </div>

      <!-- 正解 -->
      <v-alert v-if="escaped" type="success" class="mt-4">
        🎉 脱出成功！おめでとうございます！
      </v-alert>

      <!-- 不正解（出力違い or 空文字） -->
      <v-alert v-else-if="correct === false" type="error" class="mt-4">
        😢 出力が違います。もう一度チャレンジしてみてください。
      </v-alert>
    </v-card-text>
  </v-card>
</template>

<script>
import escape from '@/plugins/modules/escape'

export default {
  name: 'FinalProblem',
  data () {
    return {
      code: '',
      output: '',
      loading: false,
      escaped: false,
      correct: null
    }
  },
  methods: {
    async runCode () {
      this.loading = true
      this.output = ''
      this.escaped = false

      try {
        const response = await escape.runCode(6, this.code)
        this.output = response.output
        this.correct = response.correct
        if (response.correct) {
          this.escaped = true
          setTimeout(() => {
            this.$router.push('/escape/success')
          }, 3000)
        } else {
          this.showOutputError = true
          this.$emit('failed')
        }
      } catch (error) {
        this.output = error.response?.data?.error || 'エラーが発生しました'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
pre {
  background: #f8f8f8;
  padding: 8px;
  border-radius: 4px;
  max-height: 300px;
  overflow: auto;
}
</style>
