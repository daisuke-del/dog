<template>
  <v-container class="text-center py-12">
    <div class="congrats-animation mb-8">🎉</div>

    <h1 class="text-h4 font-weight-bold mb-4">脱出成功！おめでとうございます！</h1>

    <p class="text-subtitle-1 mb-6">
      あなたは全ての謎を解き明かし、見事にこの教室からの脱出に成功しました。
    </p>

    <v-btn color="primary" dark @click="$router.push('/')">
      ホームに戻る
    </v-btn>
  </v-container>
</template>

<script>
export default {
  auth: false,
  name: 'EscapeSuccess'
}
</script>

<style scoped>
.congrats-animation {
  font-size: 80px;
  animation: bounce 1s infinite;
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-20px);
  }
}
</style>
