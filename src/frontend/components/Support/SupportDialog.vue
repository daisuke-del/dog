<template>
    <v-dialog :value="dialog" @input="$emit('update:dialog', $event)" width="500">
        <v-card light>
            <v-card-title class="modal-headline grey lighten-2">
                問い合わせ内容
            </v-card-title>

            <v-card-text>
                {{ content }}
            </v-card-text>

            <v-divider />

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" text @click="supportClose">
                    閉じる
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'SupportDialog',
    props: {
        dialog: {
            type: Boolean,
            default: false
        },
        content: {
            type: String,
            default: ''
        },
    },
    methods: {
        supportClose() {
            this.$emit('support-close')
        }
    }
}
</script>