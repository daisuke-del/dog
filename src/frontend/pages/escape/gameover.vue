<template>
  <v-container class="text-center">
    <h1 class="display-1 mb-5">💥 ゲームオーバー 💥</h1>
    <p>残念！ドクロが13個に達してしまいました…</p>
    <v-btn color="primary" class="mt-4" to="/escape/start">やり直す</v-btn>
  </v-container>
</template>

<script>
export default {
  auth: false,
  name: 'EscapeGameOver'
}
</script>
