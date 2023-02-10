<template>
    <v-dialog v-model="dialog" width="500">
        <v-card light>
            <v-card-title class="text-h7 grey lighten-2">
                『顔レベル』　/ 『継続レベル』
            </v-card-title>

            <v-card-text>
                『顔レベル』は Lv.0 ~ Lv.100 の間で変動します。
                『継続レベル』は顔写真を変えずに登録していると上昇します。
                顔写真を変更すると『継続レベル』はリセットされてしまいます。
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" text @click="scoreClose">
                    閉じる
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'ScoreDialog',
    props: {
        dialog: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        scoreClose() {
            this.$emit('score-close')
        }
    }
}
</script>

<style scoped>
.v-card__text {
    margin-top: 30px;
}
</style>