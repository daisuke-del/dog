<template>
    <v-dialog v-model="dialog" width="500">
        <v-card light>
            <v-card-title class="text-h7 grey lighten-2">
                総合ランク: {{ rank }}
            </v-card-title>

            <v-card-text>
                『顔レベル』と『継続レベル』の合計で『総合ランク』が決まります。
                『総合ランク』はノーマル・ブロンズ・シルバー・ゴールドがあります。
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" text @click="rankClose">
                    閉じる
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'RankDialog',
    props: {
        dialog: {
            type: Boolean,
            default: false
        },
        rank: {
            type: String,
            default: ''
        }
    },
    methods: {
        rankClose() {
            this.$emit('rank-close')
        }
    }
}
</script>

<style scoped>
.v-card__text {
    margin-top: 30px;
}
</style>