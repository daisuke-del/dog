<template>
  <v-container class="text-center py-12">
    <h1 class="display-1 mb-6">🧩 脱出ゲーム：謎だらけのプログラミング教室からの脱出</h1>
    <p class="subtitle-1 mb-6">
      5つの試練を乗り越え、最終問題を突破して脱出を目指そう！
    </p>

    <v-btn color="primary" large @click="startGame">
      🎮 ゲームスタート！
    </v-btn>
  </v-container>
</template>

<script>
export default {
  auth: false,
  name: 'EscapeStart',
  methods: {
    startGame () {
      this.$router.push('/escape')
    }
  }
}
</script>

<style scoped>
h1 {
  font-weight: bold;
}
</style>
