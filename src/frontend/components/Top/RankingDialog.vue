<template>
    <v-dialog
        :value="dialog"
        @input="$emit('update:dialog', $event)"
        width="400"
    >
        <v-card light>
            <v-img class="top-image" :src="displayImage" cover>
                <v-card-title class="title">{{ dogInfo.name }}</v-card-title>
                <v-row class="other-image align-end d-flex justify-end mr-1">
                    <v-col cols="2">
                        <v-card max-width="70px" @click="changeImage(1)">
                            <v-img :src="dogImage1" />
                        </v-card>
                    </v-col>
                    <v-col cols="2">
                        <v-card max-width="70px" @click="changeImage(2)">
                            <v-img :src="dogImage2" />
                        </v-card>
                    </v-col>
                    <v-col cols="2">
                        <v-card max-width="70px" @click="changeImage(3)">
                            <v-img :src="dogImage3" />
                        </v-card>
                    </v-col>
                </v-row>
            </v-img>

            <v-card-subtitle class="pt-2">
                {{ dogInfo.birthday }}
            </v-card-subtitle>

            <v-card-text class="mt-0">
                {{ dogInfo.comment }}
            </v-card-text>

            <v-card-actions>
                <v-btn class="btn" depressed color="orange">
                    {{ dogInfo.breed1 }}
                </v-btn>

                <v-btn v-if="dogInfo.breed2" class="btn" depressed color="orange">
                    {{ dogInfo.breed2 }}
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
    name: 'RankingDialog',
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
                dog_image1: '0.jpg',
                dog_image2: '1.jpg',
                dog_image3: '3.jpg',
                comment: 'バニラ'
            }
        }
    },
    data () {
        return {
            displayImage: require(`@/../storage/image/dogimages/${this.dogInfo.dog_image1}`)
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
        }
    },
    watch: {
        dogInfo: {
            handler () {
                this.displayImage = require(`@/../storage/image/dogimages/${this.dogInfo.dog_image1}`);
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
</style>