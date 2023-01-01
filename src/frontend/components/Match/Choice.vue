<template>
    <div>
        <p class="big-text d-flex justify-center mt-6 mb-6">どっちが好み？</p>
        <div class="card-wrap d-flex justify-center">
            <v-card
                hover
                class="card"
                @click="choiceLeft"
            >
                <v-img :src="require(`@/../../../storage/image/faceimages/${leftImage}`)" />
            </v-card>
            <v-btn
                @click="clickAlertLeft"
            >
                <v-icon>
                    mdi-alert
                </v-icon>
                写真が適切でない
            </v-btn>
            <p class="big-text vs-text">VS</p>
            <v-card
                hover
                class="card"
                @click="choiceRight"
            >
                <v-img :src="require(`@/../../../storage/image/faceimages/${rightImage}`)" />
            </v-card>
            <v-btn
            @click="clickAlertRight"
            >
                <v-icon>
                    mdi-alert
                </v-icon>
                写真が適切でない
            </v-btn>
        </div>
        <div class="btn-wrap">
            <button class="back-btn">戻る</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MatchChoice',
    props: {
        leftImage: {
            type: String,
            require: true
        },
        rightImage: {
            type: String,
            require: true
        }
    },
    methods: {
        choiceLeft () {
            this.$emit('choiceLeft')
        },
        choiceRight () {
            this.$emit('choiceRight')
        },
        clickAlertLeft () {
            this.$emit('alertLeft');
        },
        clickAlertRight () {
            this.$emit('alertRight');
        }
    }
}
</script>
<style scoped>
.big-text {
    font-size: 1.5em;
    font-family: 'Noto Sans JP', sans-serif;
    color: slategray;
}

.card-wrap {
    text-align: center;
    align-items: center;
    margin-top: 20px;
}

.card {
    display: inline-block;
    width: 35%;
    max-width: 250px;
    margin: 10px;
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

@media screen and (min-width: 600px) {
    .big-text {
        font-size: 2em;
    }

    .card {
        margin: 20px;
    }
}
</style>
