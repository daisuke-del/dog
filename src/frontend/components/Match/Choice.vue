<template>
    <div class="choice-wrap">
        <choice-dialog :dialog.sync="choiceDialog" :face-image="this.alertImage" :isLeft="this.isLeft" @left-click="clickAlertLeft" @right-click="clickAlertRight" @choice-close="choiceClose"/>
        <div class="card-wrap d-flex justify-center">
            <div>
                <v-card light hover class="card" @click="choiceLeft">
                    <v-img :src="require(`@/../storage/image/faceimages/${leftImage}`)" />
                    <v-btn fab color="accent" class="alert-btn" @click.stop="leftDialog">
                        <v-icon small>
                            mdi-alert
                        </v-icon>
                    </v-btn>
                </v-card>
            </div>
            <p class="big-text vs-text">VS</p>
            <div>
                <v-card light hover class="card" @click="choiceRight">
                    <v-img :src="require(`@/../storage/image/faceimages/${rightImage}`)" />
                    <v-btn fab color="accent" class="alert-btn" @click.stop="rightDialog">
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
import ChoiceDialog from '@/components/Match/ChoiceDialog'
export default {
    name: 'MatchChoice',
    components: {
        ChoiceDialog
    },
    props: {
        leftImage: {
            type: String,
            default: '0.jpeg'
        },
        rightImage: {
            type: String,
            default: '1.jpeg'
        }
    },
    data () {
        return {
            choiceDialog: false,
            alertImage: '',
            isLeft: false,
        }
    },
    methods: {
        choiceLeft() {
            this.$emit('choice-left')
        },
        choiceRight() {
            this.$emit('choice-right')
        },
        clickAlertLeft() {
            this.$emit('alert-left');
        },
        clickAlertRight() {
            this.$emit('alert-right');
        },
        leftDialog() {
            this.alertImage = this.leftImage
            this.isLeft = true
            this.choiceDialog = true
        },
        rightDialog() {
            this.alertImage = this.rightImage
            this.isLeft = false
            this.choiceDialog = true
        },
        choiceClose() {
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

.btn-wrap {
    text-align: center;
    margin-bottom: 10px;
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

.back-btn {
    font-family: 'Noto Sans JP', sans-serif;
    font-size: 1em;
    color: slategray;
    background-color: white;
    width: 100px;
    height: 30px;
    border-radius: 0.3em;
    outline: 1px solid #b9c9ce;
    margin-top: 30px;
}

.back-btn:hover {
    outline: none;
    border: 2px solid #b9c9ce;
}

@media screen and (max-width: 600px) {
    .big-text {
        font-size: 1.5em;
    }

    .card {
        max-width: 170px;
        margin: 10px;
    }

    .alert-btn {
        width: 25px;
        height: 25px;
    }
}
</style>
