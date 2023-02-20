<template>
    <v-dialog :value="dialog" @input="$emit('update:dialog', $event)" width="500">
        <v-card light>
            <v-card-title class="modal-headline grey lighten-2">
                『顔レベル』Lv{{ facePoint }} 『継続レベル』{{ score }}
            </v-card-title>

            <v-card-text>
                ・『顔レベル』は Lv.0 ~ Lv.100 の間で変動します。<br>
                ・『継続レベル』は顔写真を継続的に登録していると上昇します。<br>
                　顔写真を変更すると『継続レベル』はリセットされてしまいます。
            </v-card-text>

            <v-divider />

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
        },
        score: {
            type: String,
            default: 'D'
        },
        facePoint: {
            type: Number,
            default: 0
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

.modal-headline {
    font-size: 1rem !important;
}
</style>