<template>
    <div class="all pt-4 pb-10 px-6">
        <h1>{{ breedInfo[0].name }}</h1>
        <v-breadcrumbs
            :items="items"
            divider=">"
        />
        <v-row>
            <v-col cols="6">
                <v-card>
                    <v-img :src="require(`@/assets/image/breed/${breedInfo[0].dog_image}`)"/>
                </v-card>
            </v-col>
            <v-col cols="6" class="breed-info">
                <h3>{{ breedInfo[0].name }}</h3>
                <p>原産国：{{ breedInfo[0].country }}</p>
                <p>サイズ：{{ breedInfo[0].size }}</p>
                <p>グループ：{{ breedInfo[0].group }}</p>
                <p v-if="breedInfo[0].max_width && breedInfo[0].min_width">体長：{{ breedInfo[0].min_width }}cm~{{ breedInfo[0].max_width }}cm</p>
                <p v-else-if="!breedInfo[0].max_width">体長：{{ breedInfo[0].min_width }}cm~</p>
                <p v-else-if="!breedInfo[0].min_width">体長：~{{ breedInfo[0].max_width }}cm</p>
                <p v-if="breedInfo[0].max_weight && breedInfo[0].min_weight">体重：{{ breedInfo[0].min_weight / 1000 }}kg~{{ breedInfo[0].max_weight / 1000 }}kg</p>
                <p v-else-if="!breedInfo[0].max_weight">体重：{{ breedInfo[0].min_weight / 1000 }}kg~</p>
                <p v-else-if="!breedInfo[0].min_weight">体重~{{ breedInfo[0].max_weight / 1000 }}kg</p>
            </v-col>
        </v-row>
        <div class="long-text mt-8">
            <h3>特徴</h3>
            <p>{{ breedInfo[0].character }}</p>
            <h3>性格</h3>
            <p>{{ breedInfo[0].personal }}</p>
        </div>
        <div class="text-center">
            <v-btn
                class="mt-5"
                color="primary"
                depressed
                @click="clickBack"
            >
                犬種一覧に戻る
            </v-btn>
        </div>
    </div>
</template>

<script>
import breed from '@/plugins/modules/breed'

export default {
    name: 'BreedDefault',
    auth: false,
    middleware: 'update_user_status',
    async asyncData ({ route }) {
        let breedInfo = []
        const breedPath = route.params.breed
        await breed.getBreedInfo(breedPath).then((response) => {
            breedInfo = response
        })
        return {
            breedInfo,
            breedPath
        }
    },
    data () {
        return {
            items: [
                {
                    text: 'トップ',
                    disabled: false,
                    href: '/'
                },
                {
                    text: '犬図鑑',
                    disabled: false,
                    href: '/breed'
                }
            ]
        }
    },
    computed: {
        breedName () {
            if (this.breedInfo && this.breedInfo.length > 0) {
            return this.breedInfo[0].name
            }
            return ''
        }
    },
    created () {
        this.items.push({
            text: this.breedName,
            disabled: true,
            href: `/breed/detail/${this.$route.params.breed}`
        })
    },
    methods: {
        clickBack () {
            this.$router.push('/breed')
        }
    }
}
</script>

<style scoped>
.all {
    max-width: 600px;
    margin: 0 auto;
}

h1 {
    font-family: 'Rampart One', cursive;
    color: dimgrey;
    text-align: center;
}

h3 {
    color: slategray;
    font-family: 'Noto Sans JP', sans-serif;
    margin-bottom: 8px;
}

.breed-info p {
    font-family: 'Noto Sans JP', sans-serif;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    overflow: hidden;
    margin-bottom: 4px;
    background-color: rgba(128, 128, 128, 0.1);
    padding: 5px;
    border-radius: 5px;
    backdrop-filter: blur(5px);
    font-size: 12px;
}

.long-text p {
    background-color: rgba(128, 128, 128, 0.1);
    padding: 10px;
    border-radius: 5px;
    backdrop-filter: blur(5px);
    font-size: 12px;
}

@media only screen and (min-width: 500px) {
.breed-info  p,
.long-text p {
    font-size: 16px;
  }
}
</style>