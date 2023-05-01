<template>
    <div>
        <v-list-item light>
            <v-list-item-avatar @click="clickMypage">
                <v-img :src="require('@/assets/image/dog/no-user-image-icon.png')" />
            </v-list-item-avatar>

            <v-list-item-content @click="clickMypage">
                <v-list-item-title>Guest</v-list-item-title>
            </v-list-item-content>
            <v-icon @click.stop="clickClose" :value="drawer" class="close">
                mdi-close-thick
            </v-icon>
        </v-list-item>
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
    props: {
        drawer: Boolean
    },
    data() {
        return {
            items: [
                { title: 'わんこ診断', icon: 'mdi-dog', link: '/diagnosis' },
                { title: 'ログイン', icon: 'mdi-login', link: '/login' },
                { title: '愛犬登録', icon: 'mdi-dog-service', link: '/signup' },
                { title: 'サポート', icon: 'mdi-chat-question-outline', link: '/support' }
            ],
        }
    },
    methods: {
        clickClose () {
            this.$emit('click-close', !this.drawer)
        },
        clickMypage() {
            this.$router.push('/mypage')
        }
    }
}
</script>