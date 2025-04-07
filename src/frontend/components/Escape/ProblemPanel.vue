<template>
  <v-card>
    <v-card-title>
      {{ problem.title }}
      <v-spacer />
      <v-icon v-if="isSolved" color="green">mdi-check-circle</v-icon>
    </v-card-title>

    <v-card-text>
      <div class="mb-2">
        <strong>問題：</strong> {{ problem.description }}
      </div>

      <v-textarea
        v-model="code"
        label="ここにPHPコードを入力"
        outlined
        rows="6"
        auto-grow
      />

      <v-btn color="primary" @click="runCode" :loading="loading" class="mt-3">
        実行
      </v-btn>

      <div class="mt-3">
        <div><strong>出力:</strong></div>
        <pre>{{ output }}</pre>
      </div>

      <!-- ✅ 正解メッセージ -->
      <v-alert
        v-if="showSuccess"
        type="success"
        outlined
        dense
        class="mt-2"
      >
        🎉 正解です！次の問題にもチャレンジしてみましょう！
      </v-alert>

      <!-- 🔴 出力エラー -->
      <v-alert
        v-if="showOutputError"
        type="error"
        dense
        class="mt-2"
      >
        出力が正しくありません。もう一度チャレンジしてみてください。
      </v-alert>

      <!-- 🔴 構文エラー -->
      <v-alert
        v-if="problem.structureErrors && problem.structureErrors.length"
        type="error"
        outlined
        dense
        class="mt-2"
      >
        <div v-for="(msg, i) in problem.structureErrors" :key="i">
          ⚠️ {{ msg }}
        </div>
      </v-alert>
    </v-card-text>
  </v-card>
</template>

<script>
import escape from '@/plugins/modules/escape'

export default {
  name: 'ProblemPanel',
  props: {
    problem: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      code: this.problem.code || '',
      output: '',
      loading: false,
      isSolved: false,
      showOutputError: false,
      showSuccess: false // ← 追加
    }
  },
  methods: {
    async runCode () {
      this.loading = true
      this.output = ''
      this.showOutputError = false
      this.showSuccess = false

      try {
        const response = await escape.runCode(this.problem.id, this.code)
        this.output = response.output
        const structureErrors = response.structure_errors || []

        if (response.correct) {
          this.isSolved = true
          this.showSuccess = true
          this.$emit('solved')

          // ✅ 自動でメッセージを数秒後に消す場合
          setTimeout(() => {
            this.showSuccess = false
          }, 4000)
        } else {
          this.showOutputError = true
          this.$emit('failed', {
            id: this.problem.id,
            structureErrors
          })
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
  background: #f5f5f5;
  padding: 8px;
  border-radius: 4px;
}
</style>
