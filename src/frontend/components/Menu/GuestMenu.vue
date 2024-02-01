<template>
    <div class="all">
        <v-list-item light>
            <Logo @click="clickLogo" class="ma-5" />
            <v-icon @click.stop="clickClose" :value="drawer" class="close">
                mdi-close-thick
            </v-icon>
        </v-list-item>
        <v-divider></v-divider>
        <v-list v-for="item in items" :key="item.title" dense light class="mx-5 py-0">
            <v-list-item  @click=$router.push(item.link) link class="py-2">
                <v-list-item-content>
                    <v-list-item-title
                        color="accent"
                        class="text"
                        :style="{ color: isCurrentPage(item.link) ? '#EEE' : '#505050' }"
                    >
                        {{ item.title }}
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>
    </div>
</template>

<script>
import Logo from '@/assets/image/svg/logo.svg'
export default {
    name: 'GuestMenu',
    components: {
        Logo
    },
    props: {
        drawer: Boolean
    },
    data() {
        return {
            items: [
                { title: 'ログイン', link: '/login' },
                { title: '新規登録', link: '/signup' },
                { title: 'わんこランキング', link: '/' },
                { title: 'わんこ友達を探す', link: '/dog'},
                { title: '犬種診断', link: '/diagnosis' },
                { title: '犬種図鑑', link: '/breed'},
                { title: 'サポート', link: '/support' },
                { title: '利用規約', link: '/support/terms' }
            ],
        }
    },
    methods: {
        clickClose () {
            this.$emit('click-close', !this.drawer)
        },
        clickLogo() {
            this.$router.push('/')
        },
        isCurrentPage(link) {
            if (link === '/') {
                return this.$route.path === link;
            } else {
                return this.$route.path.startsWith(link);
            }
        }
    }
}
</script>

<style scoped>
.close {
    flex: auto;
    color: #505050;
}

.text {
    font-size: 1rem !important;
    line-height: normal !important;
    font-family: 'Plus Jakarta Sans' !important;
    font-weight: bold !important;
    letter-spacing: 1.7px !important;
}

.v-divider {
    border-color: #EEE !important;
    border-width:  0.5px !important;
}
</style>
