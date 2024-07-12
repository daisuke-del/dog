<template>
  <v-app class="all">
    <v-sheet
      class="overflow-hidden bg"
    >
      <v-app-bar
        app
        elevate-on-scroll
        color="white"
        min-height="65px"
        elevation="0"
      >
        <LogoColor @click="clickLogo" class="mx-2 mt-1" />
        <v-spacer></v-spacer>

        <v-btn
          class="my-auto"
          fab
          elevation="0"
          color="#84D1E2"
          height="53"
          width="53"
          @click.stop="drawer = !drawer"
        >
          <Menu class="ma-1" />
        </v-btn>
      </v-app-bar>
      <v-snackbar
        v-model="snackbarVisible" color="red"
      >
        {{ this.$store.getters['snackbar/message'] }}
      </v-snackbar>
      <v-navigation-drawer
        v-model="drawer"
        class="menu"
        fixed
        temporary
        right
        width="250"
        height="90%"
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
      </v-navigation-drawer>
      <Nuxt class="mt-16 mb-10" />
      <v-footer
        class="sticky-footer"
        color="#84D1E2"
      >
        <Logo class="mx-auto my-2 foot-logo" @click="clickLogo" />
        <p class="mx-auto text mb-1">© dogisland All rights reserved.</p>
      </v-footer>
    </v-sheet>
  </v-app>
</template>

<script>
import Menu from '@/assets/image/svg/menu.svg'
import LogoColor from '@/assets/image/svg/logo-color.svg'
import Logo from '@/assets/image/svg/logo.svg'
import LoginMenu from '@/components/Menu/LoginMenu'
import GuestMenu from '@/components/Menu/GuestMenu'

export default {
  name: 'DefaultLayout',
  components: {
    Menu,
    Logo,
    LogoColor,
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
    clickLogo() {
      this.$router.push('/')
    }
  }
}
</script>
<style scoped>
.bg {
  height: 100%;
}

.menu {
  background-color: #84D1E2;
  border-radius: 30px 0 0 30px;
}

.foot-logo {
  width: 100%;
}

.text {
  color: white;
  font-size: 10px;
}

.sticky-footer {
  position: sticky;
  top: 100vh;
}
</style>
