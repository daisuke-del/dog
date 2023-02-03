<template>
    <v-card outlined light>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-header expand-icon="mdi-pencil" disable-icon-rotate>
                    <div class="info-display-area">
                        <div>
                            <p class="text-h6 font-weight-bold ma-0 header-text">
                                メールアドレス
                            </p>
                            <p class="text-body-1 mx-2 my-1">
                                {{ email }}
                            </p>
                        </div>
                    </div>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-divider class="mb-5" />
                    <v-stepper v-model="position" outlined alt-labels>
                        <v-stepper-header>
                            <v-stepper-step :complete="position > 1" step="1">
                                メール
                            </v-stepper-step>

                            <v-divider />

                            <v-stepper-step :complete="position > 2" step="2">
                                パスワード
                            </v-stepper-step>

                            <v-divider />

                            <v-stepper-step step="3">
                                変更完了
                            </v-stepper-step>
                        </v-stepper-header>

                        <v-stepper-items>
                            <v-stepper-content step="1">
                                <div>
                                    <p class="mb-1 text-subtitle-2 font-weight-bold">
                                        メールアドレスを変更
                                    </p>
                                    <v-form
                                        ref="emailForm"
                                        @submit.prevent
                                    >
                                        <v-text-field
                                            v-model="inputEmail"
                                            :rules="emailRules"
                                            placeholder="メールアドレス"
                                            autocomplete="off"
                                            outlined
                                            required
                                            dense
                                            class="pt-1"
                                        />
                                    </v-form>
                                    <v-btn
                                        depressed
                                        color="primary"
                                        class="submit-button"
                                        @click="clickUpdateEmail"
                                    >
                                        次へ
                                    </v-btn>
                                </div>
                            </v-stepper-content>

                            <v-stepper-content step="2">
                                <div class="mt-5" align="center">
                                    <v-form ref="passwordForm" @submit.prevent>
                                        <div class="password-text-field">
                                            <v-text-field v-model="password"
                                                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                :type="showPassword ? 'text' : 'password'" :rules="passwordRules"
                                                autocomplete="off" placeholder="パスワード" counter maxlength="32" outlined
                                                dense @click:append="showPassword = !showPassword" />
                                        </div>
                                    </v-form>
                                </div>
                                <div class="mt-5 center">
                                    <v-btn class="back-button" depressed color="#ffd52b" @click="backClick">
                                        <v-icon left>
                                            mdi-arrow-left
                                        </v-icon>
                                        前へ戻る
                                    </v-btn>
                                    <v-btn class="ml-4 ok-button" depressed color="primary" :email-loading="emailLoading"
                                        @click="okClick">
                                        OK
                                    </v-btn>
                                </div>
                            </v-stepper-content>

                            <v-stepper-content step="3">
                                <div align="center">
                                    <p>メールアドレスの変更が完了しました。</p>
                                </div>
                            </v-stepper-content>
                        </v-stepper-items>
                    </v-stepper>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
    </v-card>
</template>

<script>
export default {
    props: {
        email: {
            type: String,
            default: ''
        },
        position: {
            type: Number,
            default: 1
        },
        emailLoading: {
            type: Boolean,
            required: true
        },
        emailRules: {
            type: Array,
            default: () => []
        },
        passwordRules: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            password: '',
            showPassword: false,
            inputEmail: ''
        }
    },
    methods: {
        clickUpdateEmail() {
            this.$emit('clickUpdateEmail', this.inputEmail)
        },
        backClick() {
            this.$emit('backClick')
        },
        okClick() {
            if (this.$refs.form.validate()) {
                this.$emit('okClick', this.password)
            }
        }
    }
}
</script>

<style scoped>
@import 'assets/style/mypage/account.css';

.password-text-field {
    width: 80%;
}

.center {
    display: flex;
    justify-content: center;
    align-items: center;
}

.back-button,
.ok-button {
    font-weight: bold;
}

.v-stepper {
    border: 1px #ddd solid;
    box-shadow: none;
}

.v-stepper__header {
    box-shadow: none;
    border-bottom: 1px #ddd solid;
}

@media screen and (max-width: 600px) {
    .v-stepper__content {
        padding-left: 12px;
        padding-right: 12px;
    }
}

@media only screen and (max-width: 959px) {
    .v-stepper>>>.v-stepper__label {
        display: flex !important;
    }
}
</style>
