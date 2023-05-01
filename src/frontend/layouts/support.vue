<template>
  <v-app class="bg min-width">
      <v-main
          class="main"
      >
        <v-container>
          <Nuxt />
        </v-container>
      </v-main>
  </v-app>
</template>

<script>
export default {
  name: 'SupportLayout',
}
</script>

<style scoped>
.wrap {
  min-width: 360px;
}

.main {
  margin-top: 10px;
  margin-bottom: 10px;
  min-width: 360px;
}

html {
  font-family: 'Noto Sans JP', sans-serif;
}

.bg {
  background: url("~/assets/image/backGrounds/default1500.png") top center no-repeat;
}

@media screen and (min-width: 750px) {
  .header-btn {
    position: fixed;
    top: 5%;
    right: 5%;
    width: 60px;
    height: 60px;
  }
}
</style>
</style>