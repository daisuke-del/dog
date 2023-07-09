<template>
    <div class="mx-4">
        <h1>犬種図鑑</h1>
        <v-breadcrumbs
            class="bread"
            :items="items"
            divider=">"
        />
        <v-text-field
            v-model="searchKeyword"
            class="search"
            label="検索"
            outlined
            clearable
            dense
        />
        <v-row>
            <v-col cols="4">
                <select-items
                    :item-list="sizeList"
                    :select-item="sizeItem"
                    :item-label="sizeLabel"
                    @changeItem="onChangeSize"
                />
            </v-col>
            <v-col cols="4">
                <select-items
                    :item-list="groupList"
                    :select-item="groupItem"
                    :item-label="groupLabel"
                    @changeItem="onChangeGroup"
                />
            </v-col>
            <v-col cols="4">
                <select-items
                    :item-list="countryList"
                    :select-item="countryItem"
                    :item-label="countryLabel"
                    @changeItem="onChangeCountry"
                />
            </v-col>
        </v-row>
        <v-row v-if="breeds.length > 0">
            <v-col
                v-for="(breed, index) in filteredBreeds"
                :key="index"
                cols="4"
                sm="3"
                md="2"
                lg="1"
            >
                <v-card
                    elevation="0"
                    @click="clickDetail(breed.dog_image)"
                >
                    <v-img
                        :src="require(`@/assets/image/breed/${breed.dog_image}`)"
                    />
                </v-card>
                <a class="name-text mb-0" @click="clickDetail(breed.dog_image)">{{ breed.name }}</a>
            </v-col>
        </v-row>
        <p v-else class="non-text">該当する犬種が存在しません。</p>
    </div>
</template>

<script>
import breed from '@/plugins/modules/breed';
import SelectItems from '@/components/Common/SelectItems.vue';
import user from '@/plugins/modules/user'

export default {
    auth: false,
    name: 'PagesBreed',
    components: { SelectItems },
    async asyncData ({ app }) {
        if (app.$auth.loggedIn) {
            await user.getUserInfo().then((response) => {
                app.store.dispatch('authInfo/setAuthInfo', response)
            })
        }
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
            ],
            searchText: null,
            sizeList: [
                {
                    name: 'すべて',
                    value: ''
                },
                {
                    name: '超小型犬',
                    value: '超小型犬'
                },
                {
                    name: '小型犬',
                    value: '小型犬'
                },
                {
                    name: '中型犬',
                    value: '中型犬'
                },
                {
                    name: '大型犬',
                    value: '大型犬'
                }
            ],
            sizeItem: {},
            sizeLabel: 'サイズで絞り込み',
            groupList: [
                {
                    name: 'すべて',
                    value: '',
                },
                {
                    name: '1G [牧草犬・牧畜犬]',
                    value: '1G'
                },
                {
                    name: '2G [使役犬]',
                    value: '2G'
                },
                {
                    name: '3G [テリア]',
                    value: '3G'
                },
                {
                    name: '4G [ダックスフンド]',
                    value: '4G'
                },
                {
                    name: '5G [原始的な犬・スピッツ]',
                    value: '5G'
                },
                {
                    name: '6G [嗅覚ハウンド]',
                    value: '6G'
                },
                {
                    name: '7G [ポインター・セター]',
                    value: '7G'
                },
                {
                    name: '8G [7G以外の鳥猟犬]',
                    value: '8G'
                },
                {
                    name: '9G [愛玩犬]',
                    value: '9G'
                },
                {
                    name: '10G [視覚ハウンド]',
                    value: '10G'
                }
            ],
            groupItem: {},
            groupLabel: 'グループで絞り込み',
            countryList: [
                {
                    name: 'すべて',
                    value: ''
                },
                {
                    name: 'メキシコ',
                    value: 'メキシコ'
                },
                {
                    name: '日本',
                    value: '日本'
                },
                {
                    name: 'ドイツ',
                    value: 'ドイツ'
                },
                {
                    name: 'イギリス',
                    value: 'イギリス'
                },
                {
                    name: 'フランス',
                    value: 'フランス'
                },
                {
                    name: 'スコットランド',
                    value: 'スコットランド'
                },
                {
                    name: 'コンゴ民主共和国',
                    value: 'コンゴ民主共和国'
                },
                {
                    name: 'アメリカ',
                    value: 'アメリカ'
                },
                {
                    name: 'ウェールズ',
                    value: 'ウェールズ'
                },
                {
                    name: 'イングランド',
                    value: 'イングランド'
                },
                {
                    name: '中国',
                    value: '中国'
                },
                {
                    name: 'ロシア',
                    value: 'ロシア'
                },
                {
                    name: 'スイス',
                    value: 'スイス'
                },
                {
                    name: 'ベルギー',
                    value: 'ベルギー'
                },
                {
                    name: '中央地中海沿岸地域',
                    value: '中央地中海沿岸地域'
                }
            ],
            countryItem: {},
            countryLabel: '国名で絞り込み',
            searchKeyword: ''
        }
    },
    computed: {
        filteredBreeds() {
            if (this.searchKeyword) {
                var searchKeyword = this.toKatakana(this.searchKeyword)
                return this.breeds.filter((breed) => {
                    var breedName = this.toKatakana(breed.name)
                    return breedName.includes(searchKeyword)
                })
            } else {
                return this.breeds;
            }
        }
    },
    methods: {
        clickDetail (breedImagePath) {
            const breed = breedImagePath.replace(".png", "")
            this.$router.push(`/breed/detail/${breed}`)
        },
        onChangeSize (value) {
            this.sizeItem.name = value
            breed.getBreedsSort(this.sizeItem.name, this.groupItem.name, this.countryItem.name).then((response) => {
                this.breeds = response
            })
        },
        onChangeGroup (value) {
            this.groupItem.name = value
            breed.getBreedsSort(this.sizeItem.name, this.groupItem.name, this.countryItem.name).then((response) => {
                this.breeds = response
            })
        },
        onChangeCountry (value) {
            this.countryItem.name = value
            breed.getBreedsSort(this.sizeItem.name, this.groupItem.name, this.countryItem.name).then((response) => {
                this.breeds = response
            })
        },
        toKatakana(str) {
            return str.replace(/[\u3041-\u3096]/g, function(match) {
                var chr = match.charCodeAt(0) + 0x60;
                return String.fromCharCode(chr);
            })
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

.search {
    max-width: 300px;
    margin: 0 auto;
}

.name-text {
    color: slategray;
    font-family: 'Noto Sans JP', sans-serif;
    font-size: 12px;
    font-weight: bold;
}

.non-text {
    text-align: center;
    font-weight: bold;
    color: slategray;
    font-size: 1.2em;
    margin-top: 40px;
}
</style>