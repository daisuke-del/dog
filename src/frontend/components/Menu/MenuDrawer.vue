<template>
    <div>
        <template v-if="$store.$auth.loggedIn">
            <login-menu/>
        </template>
        <template v-else>
            <guest-menu/>
        </template>
    </div>
</template>

<script>
import LoginMenu from '@/components/Menu/LoginMenu'
import GuestMenu from '@/components/Menu/GuestMenu'
import LoginMenu from './LoginMenu.vue'
import GuestMenu from './GuestMenu.vue'

export default {
  components: { LoginMenuGuestMenu },
    name: 'MenuDrawer',
    comments: {
        LoginMenu,
        GuestMenu
    }
}
</script>

<style>
</style>