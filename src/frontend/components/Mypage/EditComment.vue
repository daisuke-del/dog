<template>
    <v-form ref="form" @submit.prevent>
        <v-textarea
            label="コメントを入力"
            outlined
            background-color="white"
            :rules="commentRules"
            :value="inputComment"
            @input="$emit('update:inputComment', $event)"
        ></v-textarea>
        <v-tooltip v-model="showTooltip" top>
            <template v-slot:activator="{ attrs }">
                <v-btn depressed color="primary" class="submit-button mb-2" :loading="loading"
                    v-bind="attrs" @click="submit">
                    コメントを更新
                </v-btn>
            </template>
            <span>更新しました</span>
        </v-tooltip>
    </v-form>
</template>

<script>
export default {
    props: {
        inputComment: {
            type: String,
            default: null
        },
        commentRules: {
            type: Array,
            default: () => []
        },
        showTooltip: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        submit() {
            if (this.$refs.form.validate()) {
                this.$emit('editComment', this.inputComment)
            }
        }
    }
}
</script>

<style scoped>

</style>
