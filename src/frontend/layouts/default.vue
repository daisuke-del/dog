<template>
  <v-app class="bg">
   <v-sheet
      class="overflow-hidden bg"
   >
      <v-btn
          @click.stop="drawer = !drawer"
          fab
          elevation="3"
          color="primary"
          class="header-btn"
      >
        <v-icon>
          mdi-menu
        </v-icon>
      </v-btn>
      <Nuxt />
    <v-navigation-drawer
        v-model="drawer"
        class="menu"
        fixed
        temporary
        right
        width="210px"
    >
      <v-list-item
          @click="$router.push('/mypage')"
          light
      >
        <v-list-item-avatar>
          <v-img :src="require('@/../../storage/image/faceimages/no-user-image-icon.jpeg')"></v-img>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title>Guest</v-list-item-title>
        </v-list-item-content>
        <v-icon
          @click.stop="drawer = !drawer"
        >
          mdi-close-thick
        </v-icon>
      </v-list-item>
      <v-list dense light>
        <v-list-item
          v-for="item in items"
          @click=$router.push(item.link)
          :key="item.title"
          link
        >
          <v-list-item-icon>
            <v-icon >
              {{ item.icon }}
            </v-icon>
          </v-list-item-icon>
          <v-list-item-content >
            <v-list-item-title
              color="accent"
            >
              {{ item.title }}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-list-item
        @click=$router.push(home)
        class="menu-logo"
        link
      >
        <v-img
          :src="require('@/../../storage/image/logo/logotouka.png')"
        />
      </v-list-item>
    </v-navigation-drawer>
  </v-sheet>
  </v-app>
</template>

<script>
export default {
  name: 'DefaultLayout',
  data() {
    return {
      drawer: null,
      items: [
        { title: 'マッチング診断', icon: 'mdi-face-recognition', link: '/match' },
        { title: 'ログイン', icon: 'mdi-door-open', link: '/login' },
        { title: '会員登録', icon: 'mdi-account-plus', link: '/signup' }
      ],
      title: '',
      home: '/'
    }
  },
}
</script>
<style scoped>
html {
  font-family: 'Noto Sans JP', sans-serif;
}

.bg {
  background: url("~assets/backGrounds/default750.png") top center no-repeat;
}

.menu {
  background: url("~assets/backGrounds/menu-background.png");
}

.menu-logo {
  padding:10px 30px;
}

.header-btn {
  position: fixed;
  top: 3%;
  right: 3%;
  z-index: 5;
  width: 40px;
  height: 40px;
  background: url('~assets/icons/menuIconOrange.png') center center;
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
