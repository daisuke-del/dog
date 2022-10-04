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
  background: url("~assets/backGrounds/default750.png") top center no-repeat;
}

@media screen and (min-width: 750px) {
  .bg {
    background: url("~assets/backGrounds/default3000.png") top center no-repeat;
  }

  .header-btn {
  position: fixed;
  top: 5%;
  right: 5%;
  width: 60px;
  height: 60px;
}
}

@media screen and (min-width: 1499px) {
  .bg {
    background: url("~assets/backGrounds/default4500.png") top center no-repeat;
  }
}
</style>
</style>