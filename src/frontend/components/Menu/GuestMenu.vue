<template>
    <div>
        <v-list dense light>
            <v-list-item v-for="item in items" @click=$router.push(item.link) :key="item.title" link>
                <v-list-item-icon>
                    <v-icon>
                        {{ item.icon }}
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title color="accent">
                        {{ item.title }}
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </div>
</template>

<script>
export default {
    name: 'GuestMenu',
    date() {
        return {
            items: [
                { title: 'マッチング診断', icon: 'mdi-face-recognition', link: '/match' },
                { title: 'ログイン', icon: 'mdi-door-open', link: '/login' },
                { title: '会員登録', icon: 'mdi-account-plus', link: '/signup' }
            ],
        }
    }
}
</script>