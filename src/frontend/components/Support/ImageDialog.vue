<template>
    <v-dialog
        :value="dialog"
        @input="$emit('update:dialog', $event)"
        width="400"
    >
        <v-card light @click="checkImage">
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
            <p class="font-weight-bold">選択中の画像</p>
            <p v-if="image1">画像1</p>
            <p v-if="image2">画像2</p>
            <p v-if="image3">画像3</p>

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

            <v-card-actions>
                <v-btn class="mb-2" depressed @click="clickSend">送信</v-btn>
            </v-card-actions>

            <v-card-actions>
                <v-btn class="mb-2" depressed @click="choiceClose">閉じる</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import admin from '@/plugins/modules/admin'

export default {
    name: 'ImageDialog',
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
            displayImage: require(`@/../storage/image/dogimages/${this.dogInfo.dog_image1}`),
            image1: false,
            image2: false,
            image3: false
        }
    },
    computed: {
        dogImage1 () {
            return this.dogInfo.dog_image1 && require(`@/../storage/image/dogimages/${this.dogInfo.dog_image1}`)
        },
        dogImage2 () {
            return this.dogInfo.dog_image2 && require(`@/../storage/image/dogimages/${this.dogInfo.dog_image2}`)
        },
        dogImage3 () {
            return this.dogInfo.dog_image3 && require(`@/../storage/image/dogimages/${this.dogInfo.dog_image3}`)
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
        checkImage () {
            if (this.displayImage === this.dogImage1) {
                if (this.image1) {
                    this.image1 = false
                } else {
                    this.image1 = true
                }
            } else if (this.displayImage === this.dogImage2) {
                if (this.image2) {
                    this.image2 = false
                } else {
                    this.image2 = true
                }
            } else if (this.displayImage === this.dogImage3) {
                if (this.image3) {
                    this.image3 = false
                } else {
                    this.image3 = true
                }
            }
        },
        clickSend () {
            admin.deleteVoidImage(this.dogInfo.user_id, this.image1, this.image2, this.image3).then(() => { })
        }
    },
    watch: {
        dogInfo: {
            handler () {
                this.displayImage = require(`@/../storage/image/dogimages/${this.dogInfo.dog_image1}`)
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