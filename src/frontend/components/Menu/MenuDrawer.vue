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