<template>
    <div>
        <v-list-item light>
            <v-list-item-avatar @click="clickMypage">
                <v-img :src="require('@/../storage/image/faceimages/99.jpeg')" />
            </v-list-item-avatar>

            <v-list-item-content @click="clickMypage">
                <v-list-item-title>Name</v-list-item-title>
            </v-list-item-content>
            <v-icon @click.stop="clickClose" :value="drawer" class="close">
                mdi-close-thick
            </v-icon>
        </v-list-item>
        <v-list dense light>
            <v-list-item @click="clickMatch" link>
                <v-list-item-icon>
                    <v-icon>
                        mdi-face-recognition
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title color="accent">
                        マッチング診断
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
    methods: {
        clickClose() {
            this.$emit('click-close', !this.drawer)
        },
        clickLogout() {
            user.logout().then(() => {
                this.clickClose()
            })
        },
        clickMypage() {
            this.$router.push('/mypage')
        },
        clickMatch() {
            this.$router.push('/match')
        }
    }
}
</script>