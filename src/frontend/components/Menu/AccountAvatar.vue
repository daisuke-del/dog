<template>
    <div>
        <template v-if="$store.$auth.loggedIn">
            <login-avatar/>
        </template>
        <template v-else>
            <guest-avatar/>
        </template>
    </div>
</template>

<script>
import LoginAvatar from '@/components/Menu/LoginAvatar'
import GuestAvatar from '@/components/Menu/GuestAvatar'
import LoginAvatar from './LoginAvatar.vue'
import GuestAvatar from './GuestAvatar.vue'
export default {
    name: 'AccountAvatar',
    components: {
        LoginAvatar,
        GuestAvatar
    }
}
</script>