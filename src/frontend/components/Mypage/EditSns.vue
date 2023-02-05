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
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            Facebook
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field
                                    :value="inputFacebook"
                                    :rules="facebookRules"
                                    placeholder="Facebook"
                                    autocomplete="off"
                                    outlined
                                    required
                                    dense
                                    @input="$emit('update:inputFacebook', $event)"
                                />
                            </div>
                            <v-tooltip v-model="showFacebookTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="facebookLoading"
                                        v-bind="attrs" @click="submitFacebook">
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                    <v-form ref="instagramForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            Instagram
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field
                                    :value="inputInstagram"
                                    :rules="instagramRules"
                                    placeholder="Instagram"
                                    autocomplete="off"
                                    outlined
                                    required
                                    dense
                                    @input="$emit('update:inputInstagram', $event)"
                                />
                            </div>
                            <v-tooltip v-model="showInstagramTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="instagramLoading"
                                        v-bind="attrs" @click="submitInstagram">
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                    <v-form ref="twitterForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            Twitter
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field
                                    :value="inputTwitter"
                                    :rules="twitterRules"
                                    placeholder="twitter"
                                    autocomplete="off"
                                    outlined
                                    required
                                    dense
                                    @input="$emit('update:inputTwitter', $event)"
                                />
                            </div>
                            <v-tooltip v-model="showTwitterTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="twitterLoading"
                                        v-bind="attrs" @click="submitTwitter">
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
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
        inputFacebook: {
            type: String,
            default: ''
        },
        inputInstagram: {
            type: String,
            default: ''
        },
        inputTwitter: {
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
    data () {
        return {
            facebookAccount: null,
            instagramAccount: null,
            twitterAccount: null
        }
    },
    methods: {
        submitFacebook() {
            if (this.$refs.facebookForm.validate()) {
                if (this.inputFacebook.match(/^https:\/\/(ja-jp.facebook.com\/)/)) {
                    this.facebookAccount = this.inputFacebook.replace('https://ja-jp.facebook.com/', '')
                } else {
                    this.facebookAccount = this.inputFacebook
                }
                this.$emit('editFacebook', this.inputFacebook)
            }
        },
        submitInstagram() {
            if (this.$refs.instagarmForm.validate()) {
                if (this.inputInstagram.match(/^https:\/\/(www.instagram.com\/)/)) {
                    this.instagramAccount = this.inputInstagram.replace('https://www.instagram.com/', '')
                } else {
                    this.instagramAccount = this.inputInstagram
                }
                this.$emit('editInstagram', this.instagramAccount)
            }
        },
        submitTwitter() {
            if (this.$refs.twitterForm.validate()) {
                if (this.inputTwitter.match(/^https:\/\/(twitter.com\/)/)) {
                    console.log('a')
                    this.twitterAccount = this.inputTwitter.replace('https://twitter.com/', '')
                } else {
                    this.twitterAccount = this.inputTwitter
                }
                this.$emit('editTwitter', this.twitterAccount)
            }
        }
    }
}
</script>

<style scoped>
@import 'assets/style/mypage/account.css';
</style>
