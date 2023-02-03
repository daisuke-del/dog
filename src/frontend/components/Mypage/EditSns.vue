<template>
    <v-card outlined light>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-header expand-icon="mdi-pencil" disable-icon-rotate>
                    <div class="info-display-area">
                        <div>
                            <p class="text-h6 font-weight-bold ma-0">
                                SNSアカウント
                            </p>
                        </div>
                    </div>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-divider class="mb-5" />
                    <v-form ref="facebookForm" @submit.prevent>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field v-model="facebookId" placeholder="Facebook" :rules="facebookRules"
                                    autocomplete="off" outlined required dense />
                            </div>
                            <v-tooltip v-model="showFacebookTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="facebookLoading"
                                        v-bind="attrs" @click="submitFacebook">
                                        登録
                                    </v-btn>
                                </template>
                                <span>更新しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                    <v-form ref="instagramForm" @submit.prevent>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field v-model="instagramId" placeholder="Instagram" :rules="instagramRules"
                                    autocomplete="off" outlined required dense />
                            </div>
                            <v-tooltip v-model="showInstagramTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="twitterLoading"
                                        v-bind="attrs" @click="submitInstagram">
                                        登録
                                    </v-btn>
                                </template>
                                <span>更新しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                    <v-form ref="twitterForm" @submit.prevent>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field v-model="twitterId" placeholder="twitter" :rules="twitterRules"
                                    autocomplete="off" outlined required dense />
                            </div>
                            <v-tooltip v-model="showTwitterTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="twitterLoading"
                                        v-bind="attrs" @click="submitTwitter">
                                        登録
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
        facebookId: {
            type: String,
            default: ''
        },
        instagramId: {
            type: String,
            default: ''
        },
        twitterId: {
            type: String,
            default: ''
        },
        facebookRules: {
            type: Array,
            default: () => []
        },
        instagramRules: {
            type: Array,
            default: () => []
        },
        twitterRules: {
            type: Array,
            default: () => []
        },
        facebookLoading: {
            type: Boolean,
            default: false
        },
        instagramLoading: {
            type: Boolean,
            default: false
        },
        twitterLoading: {
            type: Boolean,
            default: false
        },
        showFacebookTooltip: {
            type: Boolean,
            default: false
        },
        showInstagramTooltip: {
            type: Boolean,
            default: false
        },
        showTwitterTooltip: {
            type: Boolean,
            default: false
        },
        facebookLoading: {
            type: Boolean,
            default: false
        },
        instagramLoading: {
            type: Boolean,
            default: false
        },
        twitterLoading: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            inputFacebook: null,
            inputInstagram: null,
            inputTwitter: null
        }
    },
    methods: {
        submitFacebook() {
            if (this.$refs.facebookForm.validate()) {
                this.$emit('editFacebook', this.inputFacebook)
            }
        },
        submitInstagram() {
            if (this.$refs.instagarmForm.validate()) {
                this.$emit('editInstagram', this.inputInstagram)
            }
        },
        submitTwitter() {
            if (this.$refs.twitterForm.validate()) {
                this.$emit('editTwitter', this.inputTwitter)
            }
        }
    }
}
</script>

<style scoped>
@import 'assets/style/mypage/account.css';
</style>
