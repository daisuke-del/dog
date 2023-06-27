<template>
    <v-dialog
        :value="dialog"
        @input="$emit('update:dialog', $event)"
        width="400"
    >
        <v-card light>
            <v-img class="top-image" :src="displayImage" cover>
                <v-card-title class="title">{{ dogInfo.name }}</v-card-title>
                <v-row v-if="dogImage2" class="other-image align-end d-flex justify-end mr-1">
                    <v-col v-if="dogImage2" cols="2">
                        <v-card max-width="70px" @click="changeImage(1)">
                            <v-img :src="dogImage1" />
                        </v-card>
                    </v-col>
                    <v-col v-if="dogImage2" cols="2">
                        <v-card max-width="70px" @click="changeImage(2)">
                            <v-img :src="dogImage2" />
                        </v-card>
                    </v-col>
                    <v-col v-if="dogImage3" cols="2">
                        <v-card max-width="70px" @click="changeImage(3)">
                            <v-img :src="dogImage3" />
                        </v-card>
                    </v-col>
                </v-row>
            </v-img>

            <v-card-subtitle class="pt-2 pb-0">
                生年月日：{{ dogBirthday }}
            </v-card-subtitle>
            <v-card-subtitle>
                年齢：{{ dogAge }}歳
            </v-card-subtitle>

            <v-card-text class="mt-0">
                {{ dogInfo.comment }}
            </v-card-text>

            <v-card-actions>
                <v-btn class="btn"
                    depressed
                    color="primary"
                    @click="clickBreed(dogInfo.breed1)"
                >
                    {{ dogInfo.breed1 }}
                </v-btn>
            </v-card-actions>
            <v-card-actions v-if="dogInfo.breed2">
                <v-btn
                    class="btn"
                    depressed
                    color="primary"
                    @click="clickBreed(dogInfo.breed2)"
                >
                    {{ dogInfo.breed2 }}
                </v-btn>
            </v-card-actions>

            <v-card-actions v-if="dogInfo.twitter_id || dogInfo.instagram_id || dogInfo.tiktok_id || dogInfo.blog_id">
                <v-btn
                    v-if="dogInfo.twitter_id"
                    dark
                    depressed
                    color="#1DA1F2"
                    @click="clickTwitter(dogInfo.twitter_id)"
                >
                    <v-icon>
                        mdi-twitter
                    </v-icon>
                </v-btn>
                <v-btn
                    v-if="dogInfo.instagram_id"
                    dark
                    depressed
                    color="#C13584"
                    @click="clickInstagram(dogInfo.instagram_id)"
                >
                    <v-icon>
                        mdi-instagram
                    </v-icon>
                </v-btn>
                <v-btn
                    v-if="dogInfo.tiktok_id"
                    depressed
                    color="grey"
                    @click="clickTiktok(dogInfo.tiktok_id)"
                >
                    <template v-slot:default>
                        <v-avatar size="24">
                            <img src="@/assets/image/icons/tiktok.png" />
                        </v-avatar>
                    </template>
                </v-btn>
                <v-btn
                    v-if="dogInfo.blog_id"
                    dark
                    depressed
                    color="primary"
                    @click="clickBlog(dogInfo.blog_id)"
                >
                    <v-icon>
                        mdi-post
                    </v-icon>
                </v-btn>
            </v-card-actions>

            <v-card-actions v-if="$auth.loggedIn" class="text-center">
                <v-btn
                    v-if="dogInfo.is_matched && (dogInfo.user_id !== $store.getters['authInfo/userId'])"
                    outlined
                    @click="deleteFavorite(dogInfo.user_id)"
                >
                    <v-icon color="pink">
                        mdi-heart
                    </v-icon>
                    Friend!!
                </v-btn>
                <v-btn
                    v-else-if="dogInfo.to_user_id === dogInfo.user_id && (dogInfo.user_id !== $store.getters['authInfo/userId'])"
                    @click="addFavorite(dogInfo.user_id)"
                    icon
                >
                    <v-icon color="pink">
                        mdi-heart
                    </v-icon>
                </v-btn>
                <v-btn
                    v-else-if="dogInfo.user_id !== $store.getters['authInfo/userId']"
                    @click="addFavorite(dogInfo.user_id)"
                    icon
                >
                    <v-icon>
                        mdi-heart
                    </v-icon>
                </v-btn>
            </v-card-actions>

            <v-card-actions>
                <v-btn class="mb-2" depressed @click="choiceClose">閉じる</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'UserDialog',
    props: {
        dialog: {
            type: Boolean,
            default: false
        },
        dogInfo: {
            type: Object,
            default: {
                name: 'バニラ',
                birthday: '2022年1月3日',
                dog_image1: '4.jpg',
                dog_image2: '1.jpg',
                dog_image3: '3.jpg',
                comment: 'バニラ',
                twitter_id: '',
                instagram_id: '',
                tiktok_id: '',
                blog_id: ''
            }
        }
    },
    data () {
        return {
            displayImage: `http://dogiland.jp/storage/${this.dogInfo.dog_image1}`
        }
    },
    computed: {
        dogImage1 () {
            return this.dogInfo.dog_image1 && `http://dogiland.jp/storage/${this.dogInfo.dog_image1}`
        },
        dogImage2 () {
            return this.dogInfo.dog_image2 && `http://dogiland.jp/storage/${this.dogInfo.dog_image2}`
        },
        dogImage3 () {
            return this.dogInfo.dog_image3 && `http://dogiland.jp/storage/${this.dogInfo.dog_image3}`
        },
        dogAge () {
            const birthDate = new Date(this.dogInfo.birthday);
            const today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();

            if (today.getMonth() < birthDate.getMonth() ||
                (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age
        },
        dogBirthday () {
            const birthDate = new Date(this.dogInfo.birthday);
            const year = birthDate.getFullYear();
            const month = ("0" + (birthDate.getMonth() + 1)).slice(-2);
            const day = ("0" + birthDate.getDate()).slice(-2);
            return `${year}年${month}月${day}日`;
        }
    },
    methods: {
        choiceClose() {
            this.$emit('choice-close')
        },
        changeImage (num) {
            if (num === 1) {
                this.displayImage = this.dogImage1
            } else if (num === 2) {
                this.displayImage = this.dogImage2
            } else if (num === 3) {
                this.displayImage = this.dogImage3
            }
        },
        clickTwitter (link) {
            const url = `https://twitter.com/${link}`
            window.open(url, '_blank')
        },
        clickInstagram (link) {
            const url = `https://www.instagram.com/${link}`
            window.open(url, '_blank')
        },
        clickTiktok (link) {
            const url = `https://www.tiktok.com/${link}`
            window.open(url, '_blank')
        },
        clickBlog (link) {
            window.open(link, '_blank')
        },
        addFavorite (friendId) {
            this.$emit('add-favorite', friendId)
        },
        deleteFavorite (friendId) {
            this.$emit('delete-favorite', friendId)
        },
        clickBreed (breed) {
            this.$router.push({ path: '/dog', query: { breed: breed } });
        }
    },
    watch: {
        dogInfo: {
            handler () {
                this.displayImage = `http://dogiland.jp/storage/${this.dogInfo.dog_image1}`
            },
            deep: true,
        }
    }
}
</script>

<style scoped>
.col-2 {
    padding: 0 !important;
    margin: 3px !important;
}

.v-card__text {
    margin-top: 30px;
}

.top-image {
    position: relative;
}

.other-image {
    position: absolute;
    bottom: 5%;
    right: 0;
}

.btn {
    color: white;
    font-weight: bold;
}

.title {
    color: white;
}

.friend-text {
    font-weight: bold;
}
</style>