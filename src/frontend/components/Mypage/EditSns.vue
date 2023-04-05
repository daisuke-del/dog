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
                    <v-form ref="tiktokForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            Blog
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field
                                    :value="inputTiktok"
                                    :rules="tiktokRules"
                                    placeholder="tiktok"
                                    autocomplete="off"
                                    outlined
                                    required
                                    dense
                                    @input="$emit('update:inputTiktok', $event)"
                                />
                            </div>
                            <v-tooltip v-model="showTiktokTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="tiktokLoading"
                                        v-bind="attrs" @click="submitTiktok">
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                    <v-form ref="blogForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            Blog
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field
                                    :value="inputBlog"
                                    :rules="blogRules"
                                    placeholder="blog"
                                    autocomplete="off"
                                    outlined
                                    required
                                    dense
                                    @input="$emit('update:inputBlog', $event)"
                                />
                            </div>
                            <v-tooltip v-model="showBlogTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="blogLoading"
                                        v-bind="attrs" @click="submitBlog">
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
        inputInstagram: {
            type: String,
            default: ''
        },
        inputTwitter: {
            type: String,
            default: ''
        },
        inputTiktok: {
            type: String,
            default: ''
        },
        inputBlog: {
            type: String,
            default: ''
        },
        instagramRules: {
            type: Array,
            default: () => []
        },
        twitterRules: {
            type: Array,
            default: () => []
        },
        tiktokRules: {
            type: Array,
            default: () => []
        },
        blogRules: {
            type: Array,
            default: () => []
        },
        instagramLoading: {
            type: Boolean,
            default: false
        },
        twitterLoading: {
            type: Boolean,
            default: false
        },
        tiktokLoading: {
            type: Boolean,
            default: false
        },
        blogLoading: {
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
        showTiktokTooltip: {
            type: Boolean,
            default: false
        },
        showBlogTooltip: {
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
        tiktokLoading: {
            type: Boolean,
            default: false
        },
        blogLoading: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            instagramAccount: null,
            twitterAccount: null,
            tiktokAccount: null,
            blogAccount: null
        }
    },
    methods: {
        submitInstagram() {
            if (this.$refs.instagramForm.validate()) {
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
                    this.twitterAccount = this.inputTwitter.replace('https://twitter.com/', '')
                } else {
                    this.twitterAccount = this.inputTwitter
                }
                this.$emit('editTwitter', this.twitterAccount)
            }
        },
        submitTiktok() {
            if (this.$refs.tiktokForm.validate()) {
                if (this.inputTiktok.match(/^https:\/\/(tiktok.com\/)/)) {
                    this.tiktokAccount = this.inputTiktok.replace('https://tiktok.com/', '')
                } else {
                    this.tiktokAccount = this.inputTiktok
                }
                this.$emit('editTiktok', this.tiktokAccount)
            }
        },
        submitBlog() {
            this.blogAccount = this.inputBlog
            this.$emit('editBlog', this.blogAccount)
        }
    }
}
</script>

<style scoped>
@import 'assets/style/mypage/account.css';
</style>
