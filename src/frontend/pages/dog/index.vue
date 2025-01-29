<template>
  <div class="all mb-12">
    <user-dialog
      :dialog.sync="userDialog"
      :dog-info="dogInfo"
      @choice-close="choiceClose"
      @add-favorite="addFavorite"
      @delete-favorite="deleteFavorite"
    />
    <h3 class="headline-dog pt-10">
      <PawsIcon class="headline-text" />
      <span class="headline-text">わんこの友達を探す</span>
    </h3>
    <v-container class="search-container" fluid>
      <v-row class="justify-center" no-gutters>
        <v-col cols="12" sm="6" class="px-sm-2">
          <v-text-field
            v-model="searchNameKeyword"
            class="mb-2"
            label="名前検索"
            outlined
            clearable
            dense
            hide-details
          />
        </v-col>
        <v-col cols="12" sm="6" class="px-sm-2">
          <v-text-field
            v-model="searchBreedKeyword"
            class="mb-2"
            label="犬種検索"
            outlined
            clearable
            dense
            hide-details
          />
        </v-col>
      </v-row>
    </v-container>
    <v-row v-if="users.length > 0">
      <v-col
        v-for="(user, index) in filteredUsers"
        :key="index"
        cols="4"
        sm="3"
        lg="2"
        xl="1"
      >
        <v-card
          elevation="0"
          @click="clickUser(user, index)"
        >
          <v-img :src="getImageUrl(user.dog_image1)" />
        </v-card>
        <a
          class="name-text mb-0"
          @click="clickUser(user)"
        >
          {{ user.name }}
        </a>
      </v-col>
    </v-row>
    <p
      v-if="!isLoading && users.length === 0"
      class="non-text"
    >
      ユーザーが存在しません。
    </p>
    <client-only>
      <infinite-loading
        ref="infiniteLoading"
        spinner="spiral"
        class="infiniteLoading"
        @infinite="infiniteHandler"
      >
        <div slot="no-more" />
        <div slot="no-results">
          <p v-if="isError" class="mt-2">
            予期せぬエラーが発生しました。再度読み込んでください。
          </p>
        </div>
      </infinite-loading>
    </client-only>
  </div>
</template>

<script>
import PawsIcon from "@/assets/image/svg/paws-icon.svg";
import UserDialog from '@/components/Common/UserDialog';
import user from '@/plugins/modules/user';
import SelectItems from '@/components/Common/SelectItems.vue';
import favorite from '~/plugins/modules/favorite';
import InfiniteLoading from 'vue-infinite-loading';

export default {
  auth: false,
  name: 'PagesDog',
  components: {
    PawsIcon,
    SelectItems,
    UserDialog,
    InfiniteLoading
  },
  middleware: 'update_user_status',
  async asyncData({ query }) {
    let searchBreedKeyword = null
    if (query.breed) {
      searchBreedKeyword = query.breed
    }
    return {
      searchBreedKeyword
    }
  },
  data() {
    return {
      users: [],
      items: [
        {
          text: 'トップ',
          disabled: false,
          href: '/'
        },
        {
          text: '友達を探す',
          disabled: false,
          href: '/dog'
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
        }
      ],
      countryItem: {},
      countryLabel: '国名で絞り込み',
      searchNameKeyword: '',
      searchBreedKeyword: '',
      userDialog: false,
      dogInfo: {
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
      },
      index: null,
      isError: false,
      count: 20,
      offset: 0,
      isLoading: true
    }
  },
  beforeRouteUpdate(to, from, next) {
    next(vm => {
      vm.reloadPage()
    })
  },
  computed: {
    filteredUsers() {
      if (this.searchBreedKeyword && this.searchNameKeyword) {
        breedUser = this.filterBreed(this.users)
        return this.filterName(breedUser)
      } else if (this.searchBreedKeyword) {
        return this.filterBreed(this.users)
      } else if (this.searchNameKeyword) {
        return this.filterName(this.users)
      } else {
        return this.users
      }
    }
  },
  methods: {
    clickUser(user, index) {
      this.dogInfo = user
      this.index = index
      this.userDialog = true
    },
    toKatakana(str) {
      return str.replace(/[\u3041-\u3096]/g, function (match) {
        var chr = match.charCodeAt(0) + 0x60;
        return String.fromCharCode(chr);
      })
    },
    filterBreed(users) {
      const searchBreedKeyword = this.toKatakana(this.searchBreedKeyword)
      return users.filter((user) => {
        let breedName1 = this.toKatakana(user.breed1)
        if (user.breed2) {
          let breedName2 = this.toKatakana(user.breed2)
          return breedName1.includes(searchBreedKeyword) || breedName2.includes(searchBreedKeyword)
        } else {
          return breedName1.includes(searchBreedKeyword)
        }
      })
    },
    filterName(users) {
      const searchNameKeyword = this.toKatakana(this.searchNameKeyword)
      return users.filter((user) => {
        let userName = this.toKatakana(user.name)
        return userName.includes(searchNameKeyword)
      })
    },
    choiceClose() {
      this.userDialog = false
    },
    addFavorite(friendId) {
      if (!this.$auth.loggedIn) {
        this.$router.push('/login')
      } else {
        favorite.addFavorite(friendId).then((response) => {
          this.dogInfo = response
          this.users[this.index] = response
        })
      }
    },
    deleteFavorite(friendId) {
      if (!this.$auth.loggedIn) {
        this.$router.push('/login')
      } else {
        favorite.deleteFavorite(friendId).then((response) => {
          this.dogInfo = response
          this.users[this.index] = response
        })
      }
    },
    async getDogs() {
      this.isLoading = true;
      if (this.$auth.loggedIn) {
        user.getUsersWithFriends(this.offset).then((response) => {
          this.users.push(...response)
          if (response.length === 0) {
            this.$refs.infiniteLoading.stateChanger.complete()
            return
          }
          if (response.length < this.count) {
            this.$refs.infiniteLoading.stateChanger.complete()
          }
          this.offset += this.count
          this.$refs.infiniteLoading.stateChanger.loaded()
        }).catch((error) => {
          if (this.$axios.isCancel(error)) {
            return
          }
          this.isError = true
          this.$refs.infiniteLoading.stateChanger.complete()
        })
      } else {
        user.getUsers(this.offset).then((response) => {
          this.users.push(...response)
          if (response.length === 0) {
            this.$refs.infiniteLoading.stateChanger.complete()
            return
          }
          if (response.length < this.count) {
            this.$refs.infiniteLoading.stateChanger.complete()
          }
          this.offset += this.count
          this.$refs.infiniteLoading.stateChanger.loaded()
        }).catch((error) => {
          if (this.$axios.isCancel(error)) {
            return
          }
          this.isError = true
          this.$refs.infiniteLoading.stateChanger.complete()
        }).finally(() => {
          this.isLoading = false;
        })
      }
    },
    infiniteHandler() {
      this.getDogs()
    },
    getImageUrl(image) {
      if (!image) {
        image = '1.jpg';
      }
      return `${process.env.imageBaseUrl}/${image}`;
    },
  },
  watch: {
    $route() {
      location.reload()
    }
  },
}
</script>

<style scoped>
.all {
  padding-left: 12px;
  padding-right: 12px;
}

.headline-dog {
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: left;
}

.headline-text {
  vertical-align: middle;
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

.search-container {
  width: 100%;
  max-width: 800px;
  margin: auto;
  margin-bottom: 20px;
}

@media screen and (min-width: 600px) {
  .all {
    padding-left: 40px;
    padding-right: 40px;
  }
}

  @media screen and (max-width: 600px) {
  .search-container {
    max-width: 100%;
    padding: 0 16px;
  }
}
</style>