<template>
  <v-app class="bg">
    <v-sheet class="overflow-hidden bg">
      <v-btn @click.stop="drawer = !drawer" fab elevation="3" color="primary" class="header-btn">
        <v-icon>
          mdi-menu
        </v-icon>
      </v-btn>
      <Nuxt />
      <v-navigation-drawer v-model="drawer" class="menu" fixed temporary right width="210px">
          <v-list-item @click="$router.push('/mypage')" light>
            <account-avatar/>
            <v-icon @click.stop="drawer = !drawer">
                mdi-close-thick
            </v-icon>
          </v-list-item>

        <menu-drawer />
        <v-list-item @click=$router.push(home) class="menu-logo" link>
          <v-img :src="require('@/storage/image/logo/logotouka.png')" />
        </v-list-item>
      </v-navigation-drawer>
    </v-sheet>
  </v-app>
</template>

<script>
import user from '@/plugins/modules/user'
import AccountAvatar from '@/components/Menu/AccountAvatar'
import MenuDrawer from '@/components/Menu/MenuDrawer'
export default {
  name: 'DefaultLayout',
  components: {
    MenuDrawer,
    AccountAvatar,
    MenuDrawer,
    AccountAvatar
  },
  data() {
    return {
      drawer: null,
      title: '',
      home: '/'
    }
  },
  methods: {
    clickLogout() {
      user.logout.then((response) => {
        alert('ログアウトしました')
        console.log(response)
      }).catch((error) => {
        alert('ログアウトに失敗しました')
        console.log(error)
      })
    }
  }
}
</script>
<style scoped>
html {
  font-family: 'Noto Sans JP', sans-serif;
}

.bg {
  background: url("~assets/image/backGrounds/default750.png") top center no-repeat;
}

.menu {
  background: url("/image/backGrounds/menu-background.png");
}

.menu-logo {
  padding: 10px 30px;
}

.header-btn {
  position: fixed;
  top: 3%;
  right: 3%;
  z-index: 5;
  width: 40px;
  height: 40px;
  background: url('~assets/image/icons/menuIconOrange.png') center center;
}

@media screen and (min-width: 750px) {
  .bg {
    background: url("~assets/image/backGrounds/default3000.png") top center no-repeat;
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
    background: url("~assets/image/backGrounds/default4500.png") top center no-repeat;
  }
}
</style>
