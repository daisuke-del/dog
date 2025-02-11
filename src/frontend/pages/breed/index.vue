<template>
  <div class="mx-4">
    <h3 class="headline-dog pt-10">
      <PawsIcon class="paws-icon headline-text" />
      <span class="headline-text">わんこの友達を探す</span>
    </h3>
    <v-text-field
      v-model="searchKeyword"
      class="search pb-2"
      label="フリーワードで検索"
      prepend-inner-icon="mdi-magnify"
      hide-details
      outlined
      clearable
      dense
    />
    <v-row class="pt-2">
      <v-col class="py-1" cols="12" sm="4">
        <select-items
          :item-list="sizeList"
          :select-item="sizeItem"
          :item-label="sizeLabel"
          @changeItem="onChangeSize"
          hide-details
        />
      </v-col>
      <v-col class="py-1" cols="12" sm="4">
        <select-items
          :item-list="groupList"
          :select-item="groupItem"
          :item-label="groupLabel"
          @changeItem="onChangeGroup"
          hide-details
        />
      </v-col>
      <v-col class="py-1" cols="12" sm="4">
        <select-items
          :item-list="countryList"
          :select-item="countryItem"
          :item-label="countryLabel"
          @changeItem="onChangeCountry"
          hide-details
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
        <a class="name-text mb-0" @click="clickDetail(breed.dog_image)">
          {{ breed.name }}
        </a>
      </v-col>
    </v-row>
    <p v-if="!isLoading && breeds.length === 0" class="non-text">該当する犬種が存在しません。</p>
  </div>
</template>

<script>
import breed from '@/plugins/modules/breed';
import SelectItems from '@/components/Common/SelectItems.vue';
import PawsIcon from "@/assets/image/svg/paws-icon.svg";

export default {
  auth: false,
  name: 'PagesBreed',
  components: {
    SelectItems,
    PawsIcon,
  },
  middleware: 'update_user_status',
  data () {
    return {
      breeds: [],
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
      searchKeyword: '',
      isLoading: true
    }
  },
  created() {
    this.fetchData()
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
    async fetchData() {
      this.isLoading = true;
      await breed.getBreeds().then((response) => {
        this.breeds = response
      }).finally(() => {
        this.isLoading = false;
      })
    },
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
    },
  }
}
</script>

<style scoped>
.search {
  max-width: 600px;
  margin: 0 auto;
}

.headline-dog {
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: left;
  color: #505050;
}

.headline-text {
  vertical-align: middle;
}

.name-text {
  color: #505050;
  font-size: 12px;
  font-weight: bold;
}

.non-text {
  text-align: center;
  font-weight: bold;
  color: #505050;
  font-size: 1.2em;
  margin-top: 40px;
}

@media screen and (min-width: 600px) {
  .all {
    padding-left: 40px;
    padding-right: 40px;
  }

  .headline-text {
    font-size: 1.5em;
  }

  .paws-icon {
    width: 1.5em;
    height: 1.5em;
  }
}

</style>