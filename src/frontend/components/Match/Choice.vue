<template>
    <div class="choice-wrap">
        <div class="card-wrap d-flex justify-center">
            <div>
                <v-card hover class="card" @click="choiceLeft">
                    <v-img :src="require(`@/../storage/image/faceimages/${leftImage}`)" />
                </v-card>
                <v-btn block @click="clickAlertLeft">
                    <v-icon>
                        mdi-alert
                    </v-icon>
                    写真が適切でない
                </v-btn>
            </div>
            <p class="big-text vs-text">VS</p>
            <div>
                <v-card hover class="card" @click="choiceRight">
                    <v-img :src="require(`@/../storage/image/faceimages/${rightImage}`)" />
                </v-card>
                <v-btn block @click="clickAlertRight">
                    <v-icon>
                        mdi-alert
                    </v-icon>
                    写真が適切でない
                </v-btn>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MatchChoice',
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
}

.btn-wrap {
    text-align: center;
    margin-bottom: 10px;
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
        max-width: 150px;
        margin: 10px;
    }
}
</style>
