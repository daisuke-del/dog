<template>
    <v-dialog :value="dialog" @input="$emit('update:dialog', $event)" width="400">
        <v-card light>
            <v-card-title class="text-h7 grey lighten-2">
                顔写真以外が表示されている？
            </v-card-title>

            <v-card-text>
                この画像が顔写真でなければ『顔写真ではない！』をクリック
            </v-card-text>

            <v-img :src="faceImageModal"/>

            <v-divider />

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="btn-text" @click="alertClick">
                    顔写真ではない！
                </v-btn>
                <v-btn class="btn-text" color="accent" @click="choiceClose">
                    キャンセル
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'ChoiceDialog',
    props: {
        dialog: {
            type: Boolean,
            default: false
        },
        faceImage: {
            type: String,
            default: 'no-user-image-icon.jpeg'
        },
        isLeft: {
            type: Boolean,
            require: true
        }
    },
    computed: {
        faceImageModal () {
            return this.faceImage && require(`@/../storage/image/faceimages/${this.faceImage}`)
        },
        changeDialog () {
            return this.dialog
        }
    },
    methods: {
        alertClick() {
            if (this.isLeft) {
                this.$emit('left-click')
            } else {
                this.$emit('right-click')
            }
        },
        choiceClose() {
            this.$emit('choice-close')
        }
    }
}
</script>

<style scoped>
.v-card__text {
    margin-top: 30px;
}

.btn-text {
    font-weight: bold;
}
</style>