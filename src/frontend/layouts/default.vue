<template>
  <v-app class="bg">
    <v-sheet
      class="overflow-hidden bg"
    >
    <v-app-bar
      dense
      app
      elevate-on-scroll
      color="secondary"
      class="menu-bar"
    >
      <v-img
        class="logo"
        :src="require('@/assets/image/logo/logotouka.png')"
        @click="clickTop"
      />
      <v-spacer></v-spacer>

      <v-icon color="accent" large @click.stop="drawer = !drawer">
        mdi-menu
      </v-icon>
    </v-app-bar>
      <v-snackbar
        v-model="snackbarVisible" color="red"
      >
        {{ this.$store.getters['snackbar/message'] }}
      </v-snackbar>
      <Nuxt class="mt-16"/>
      <v-navigation-drawer
        v-model="drawer"
        class="menu"
        fixed
        temporary
        right
        width="210px"
      >
        <login-menu
          v-if="$store.$auth.loggedIn"
          :drawer="drawer"
          @click-close="closeDrawer"
        />
        <guest-menu
          v-else
          :drawer="drawer"
          @click-close="closeDrawer"
        />
        <v-list-item
          @click=$router.push(home)
          class="menu-logo"
          link
        >
          <v-img :src="require('@/assets/image/logo/logotouka.png')" />
        </v-list-item>
      </v-navigation-drawer>
    </v-sheet>
  </v-app>
</template>

<script>
import LoginMenu from '@/components/Menu/LoginMenu'
import GuestMenu from '@/components/Menu/GuestMenu'

export default {
  name: 'DefaultLayout',
  components: {
    LoginMenu,
    GuestMenu
  },
  data() {
    return {
      drawer: null,
      title: '',
      home: '/',
    }
  },
  computed: {
    snackbarVisible: {
      get() {
        return this.$store.state.snackbar.isEnable
      },
      set() {
        return this.$store.dispatch('snackbar/snackOff')
      }
    }
  },
  methods: {
    closeDrawer(value) {
      this.drawer = value
    },
    clickTop () {
      this.$router.push('/')
    }
  }
}
</script>
<style scoped>
html {
  font-family: 'Noto Sans JP', sans-serif;
}

.bg {
  background: url("~/assets/image/backGrounds/default1500.png") top center no-repeat;
}

.menu {
  background: url("~/assets/image/backGrounds/menu-background.png") top center no-repeat;
}

.menu-logo {
  padding: 10px 30px;
}

.logo {
  max-width: 100px;
}

.menu-bar {
  border-bottom: 1px solid #d5cdc8 !important;
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
