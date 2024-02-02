<template>
    <div class="all">
        <v-list-item light>
            <Logo @click="clickTop" class="ma-5" />
            <v-icon @click.stop="clickClose" :value="drawer" class="close">
                mdi-close-thick
            </v-icon>
        </v-list-item>
        <v-divider></v-divider>
        <v-list dense light class="mx-5 py-0">
            <v-list-item  @click="clickMypage" link class="py-2">
                <v-list-item-content>
                    <v-list-item-title
                        color="accent"
                        class="text"
                        :style="{ color: $route.path.startsWith('/mypage') ? '#EEE' : '#505050' }"
                    >
                        マイページ
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>

        <v-list dense light class="mx-5 py-0">
            <v-list-item  @click="clickTop" link class="py-2">
                <v-list-item-content>
                    <v-list-item-title
                        color="accent"
                        class="text"
                        :style="{ color: $route.path === '/' ? '#EEE' : '#505050' }"
                    >
                        わんこランキング
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>

        <v-list dense light class="mx-5 py-0">
            <v-list-item  @click="clickFriends" link class="py-2">
                <v-list-item-content>
                    <v-list-item-title
                        color="accent"
                        class="text"
                        :style="{ color: $route.path.startsWith('/dog') ? '#EEE' : '#505050' }"
                    >
                        わんこ友達をさがす
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>

        <v-list dense light class="mx-5 py-0">
            <v-list-item  @click="clickDiagnosis" link class="py-2">
                <v-list-item-content>
                    <v-list-item-title
                        color="accent"
                        class="text"
                        :style="{ color: $route.path.startsWith('/diagnosis') ? '#EEE' : '#505050' }"
                    >
                        犬種診断
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>

        <v-list dense light class="mx-5 py-0">
            <v-list-item  @click="clickBreeds" link class="py-2">
                <v-list-item-content>
                    <v-list-item-title
                        color="accent"
                        class="text"
                        :style="{ color: $route.path.startsWith('/breed') ? '#EEE' : '#505050' }"
                    >
                        犬種図鑑
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>

        <v-list dense light class="mx-5 py-0">
            <v-list-item  @click="clickSupport" link class="py-2">
                <v-list-item-content>
                    <v-list-item-title
                        color="accent"
                        class="text"
                        :style="{ color: $route.path === '/support' ? '#EEE' : '#505050' }"
                    >
                        お問い合わせ
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>

        <v-list dense light class="mx-5 py-0">
            <v-list-item  @click="clickTerms" link class="py-2">
                <v-list-item-content>
                    <v-list-item-title
                        color="accent"
                        class="text"
                        :style="{ color: $route.path === '/support/terms' ? '#EEE' : '#505050' }"
                    >
                        ご利用規約
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>

        <v-list dense light class="mx-5 py-0">
            <v-list-item  @click="clickLogout" link class="py-2">
                <v-list-item-content>
                    <v-list-item-title
                        color="accent"
                        class="text"
                        :style="{ color: '#505050' }"
                    >
                        ログアウト
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
        </v-list>
    </div>
</template>

<script>
import user from '@/plugins/modules/user'
import Logo from '@/assets/image/svg/logo.svg'
export default {
    name: 'LoginMenu',
    components: {
        Logo
    },
    props: {
        drawer: Boolean
    },
    methods: {
        clickClose () {
            this.$emit('click-close', !this.drawer)
        },
        clickTop() {
            this.$router.push('/')
        },
        clickMypage() {
            this.$router.push('/mypage')
        },
        clickFriends() {
            this.$router.push('/dog')
        },
        clickDiagnosis() {
            this.$router.push('/diagnosis')
        },
        clickBreeds() {
            this.$router.push('/breed')
        },
        clickSupport() {
            this.$router.push('/support')
        },
        clickTerms() {
            this.$router.push('/support/terms')
        },
        clickLogout() {
            user.logout()
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
