<template>
    <div class="choice-wrap">
        <choice-dialog
            :dialog.sync="choiceDialog"
            :dog-image="this.alertImage"
            :isLeft="this.isLeft"
            @left-click="clickAlertLeft"
            @right-click="clickAlertRight"
            @choice-close="choiceClose"
        />
        <div class="card-wrap d-flex justify-center">
            <div>
                <v-card
                    light
                    hover
                    class="card"
                    @click="choiceLeft"
                >
                    <v-img :src="leftDogImage" />
                    <v-btn
                        fab
                        color="accent"
                        class="alert-btn"
                        @click.stop="leftDialog"
                    >
                        <v-icon small>
                            mdi-alert
                        </v-icon>
                    </v-btn>
                </v-card>
            </div>
            <p class="big-text vs-text">VS</p>
            <div>
                <v-card
                    light
                    hover
                    class="card"
                    @click="choiceRight"
                >
                    <v-img :src="rightDogImage" />
                    <v-btn
                        fab
                        color="accent"
                        class="alert-btn"
                        @click.stop="rightDialog"
                    >
                        <v-icon small>
                            mdi-alert
                        </v-icon>
                    </v-btn>
                </v-card>
            </div>
        </div>
    </div>
</template>

<script>
import ChoiceDialog from '@/components/Diagnosis/ChoiceDialog'
export default {
    name: 'DiagnosisChoice',
    components: {
        ChoiceDialog
    },
    props: {
        leftDog: {
            type: Object,
            required: false
        },
        rightDog: {
            type: Object,
            required: false
        }
    },
    data () {
        return {
            choiceDialog: false,
            alertImage: '',
            isLeft: false,
        }
    },
    computed: {
        leftDogImage () {
            return this.leftDog.dog_image1 && `http://dogiland.jp/storage/${this.leftDog.dog_image1}`
        },
        rightDogImage () {
            return this.rightDog.dog_image1 && `http://dogiland.jp/storage/${this.rightDog.dog_image1}`
        }
    },
    methods: {
        choiceLeft () {
            this.$emit('choice-left')
        },
        choiceRight () {
            this.$emit('choice-right')
        },
        clickAlertLeft () {
            this.$emit('alert-left');
            this.choiceDialog = false
        },
        clickAlertRight () {
            this.$emit('alert-right');
            this.choiceDialog = false
        },
        leftDialog () {
            this.alertImage = this.leftDog.dog_image1
            this.isLeft = true
            this.choiceDialog = true
        },
        rightDialog () {
            this.alertImage = this.rightDog.dog_image1
            this.isLeft = false
            this.choiceDialog = true
        },
        choiceClose () {
            this.choiceDialog = false
        }
    }
}
</script>
<style scoped>
.big-text {
    font-size: 2em;
    font-family: 'Noto Sans JP', sans-serif;
    color: slategray;
}

.card-wrap {
    text-align: center;
    align-items: center;
    margin: 20px;
}

.card {
    display: inline-block;
    max-width: 250px;
    margin: 20px;
    position: relative;
}

.alert-btn {
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    bottom: -5%;
    right: -5%;
}

@media screen and (max-width: 600px) {
    .big-text {
        font-size: 1.5em;
    }

    .card {
        max-width: 150px;
        margin: 10px;
    }

    .alert-btn {
        width: 25px;
        height: 25px;
    }
}
</style>
