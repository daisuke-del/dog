<template>
    <v-card outlined light>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-header expand-icon="mdi-pencil" disable-icon-rotate>
                    <div class="info-display-area">
                        <div>
                            <p class="text-h6 font-weight-bold ma-0">
                                ニックネーム
                            </p>
                            <p class="text-body-1 mx-2 my-1">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-divider class="mb-5" />
                    <v-form ref="form" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            ニックネームを変更
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field v-model="inputName" placeholder="ニックネーム" :rules="nameRules"
                                    autocomplete="off" outlined required dense />
                            </div>
                            <v-tooltip v-model="showTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="loading"
                                        v-bind="attrs" @click="submit">
                                        決定
                                    </v-btn>
                                </template>
                                <span>更新しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
    </v-card>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            default: ''
        },
        nameRules: {
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
    data() {
        return {
            inputName: ''
        }
    },
    methods: {
        submit() {
            if (this.$refs.form.validate()) {
                this.$emit('editName', this.inputName)
            }
        }
    }
}
</script>

<style scoped>
@import 'assets/style/mypage/account.css';
</style>
