<template>
    <div>
        <v-list-item light>
            <v-list-item-avatar @click="clickMypage">
                <v-img :src="userWithImage" class="my-icon" />
            </v-list-item-avatar>

            <v-list-item-content @click="clickMypage">
                <v-list-item-title>{{ userName }}</v-list-item-title>
            </v-list-item-content>
            <v-icon @click.stop="clickClose" :value="drawer" class="close">
                mdi-close-thick
            </v-icon>
        </v-list-item>
        <v-divider></v-divider>
        <v-list dense light>
            <v-list-item @click="clickBreed" link>
                <v-list-item-icon>
                    <v-icon>
                        mdi-book-open-variant
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title color="accent">
                        犬種図鑑
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="clickDiagnosis" link>
                <v-list-item-icon>
                    <v-icon>
                        mdi-dog
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title color="accent">
                        わんこ診断
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="clickMypage" link>
                <v-list-item-icon>
                    <v-icon>
                        mdi-home-account
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title color="accent">
                        マイページ
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="clickAccount" link>
                <v-list-item-icon>
                    <v-icon>
                        mdi-account-outline
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title color="accent">
                        登録情報
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="clickSearch" link>
                <v-list-item-icon>
                    <v-icon>
                        mdi-magnify
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title color="accent">
                        ユーザー検索
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click=clickLogout link>
                <v-list-item-icon>
                    <v-icon>
                        mdi-door-open
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title color="accent">
                        ログアウト
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click=clickSupport link>
                <v-list-item-icon>
                    <v-icon>
                        mdi-chat-question-outline
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title color="accent">
                        サポート
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </div>
</template>

<script>
import user from '~/plugins/modules/user'
export default {
    name: 'LoginMenu',
    props: {
        drawer: Boolean
    },
    data () {
        return {
            dogImage1: this.$store.getters['authInfo/auth'].dogImage1
        }
    },
    computed: {
        userWithImage () {
            return this.dogImage1 && `http://dogiland.jp/storage/${this.dogImage1}`
        },
        userName () {
            return this.$store.getters['authInfo/auth'].name
        }
    },
    methods: {
        clickClose () {
            this.$emit('click-close', !this.drawer)
        },
        async clickLogout() {
            await this.$axios.get('/sanctum/csrf-cookie', { withCredentials: true })
            await user.logout().then(() => {
                this.clickClose()
            })
        },
        clickMypage () {
            this.$router.push('/mypage')
        },
        clickDiagnosis () {
            this.$router.push('/diagnosis')
        },
        clickBreed () {
            this.$router.push('/breed')
        },
        clickAccount () {
            this.$router.push('/mypage/account')
        },
        clickSupport () {
            this.$router.push('/support')
        },
        clickSearch () {
            this.$router.push('/dog')
        }
    }
}
</script>

<style scoped>
.my-icon {
    cursor: pointer;
}
</style>