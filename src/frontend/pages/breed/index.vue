<template>
    <div class="all mx-4">
        <h1>犬種図鑑</h1>
        <v-breadcrumbs
            class="bread"
            :items="items"
            divider=">"
        />
        <v-row>
            <v-col
                v-for="(breed, index) in breeds"
                :key="index"
                cols="4"
                sm="3"
                md="2"
                lg="1"
            >
                <v-card
                    @click="clickDetail(breed.dog_image)"
                >
                    <v-img
                        :src="require(`@/assets/image/breed/${breed.dog_image}`)"
                    />
                </v-card>
                <p class="name-text">{{ breed.name }}</p>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import breed from '@/plugins/modules/breed';
export default {
    auth: false,
    name: 'PagesBreed',
    async asyncData () {
        let breeds = []
        await breed.getBreeds().then((response) => {
            breeds = response
        })
        return {
            breeds
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
    methods: {
        clickDetail (breedImagePath) {
            const breed = breedImagePath.replace(".png", "")
            this.$router.push(`/breed/detail/${breed}`)
        }
    }
}
</script>

<style scoped>
h1 {
    font-family: 'Rampart One', cursive;
    color: dimgrey;
    text-align: center;
}

.name-text {
    color: slategray;
    font-family: 'Noto Sans JP', sans-serif;
    font-size: 12px;
    font-weight: bold;
}
</style>