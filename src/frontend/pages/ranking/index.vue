<template>
  <div class="all pb-12">
    <user-dialog
      :dialog.sync="userDialog"
      :dog-info="dogInfo"
      @choice-close="choiceClose"
      @add-favorite="addFavorite"
      @delete-favorite="deleteFavorite"
    />
    <div class="main-wrapper justify-center">
      <div class="ranking-wrap">
        <h3 class="headline-dog pt-10">
          <PawsIcon class="paws-icon headline-text" />
          <span class="headline-text">人気のわんこランキング</span>
        </h3>
        <v-row
          align="end"
          v-for="(row, rowIndex) in groupedRanking"
          :key="rowIndex"
        >
          <v-col
            v-for="(dog, colIndex) in row"
            :key="colIndex"
            cols="4"
            class="ranking-col"
          >
            <component
              :is="getRankIcon(rowIndex * 3 + colIndex)"
              v-if="rowIndex * 3 + colIndex < 3"
              class="ranking-icon"
            />
            <v-card elevation="0">
              <v-img
                :src="getImageUrl(dog.dog_image1)"
                @click="clickImage(rowIndex * 3 + colIndex)"
              />
              <p class="mb-0 ml-1">
                {{ dog.name }}
              </p>
            </v-card>
          </v-col>
        </v-row>
      </div>
    </div>
  </div>
</template>

<script>
import PawsIcon from "@/assets/image/svg/paws-icon.svg";
import RankFirst from "@/assets/image/svg/rank/1st.svg";
import RankSecound from "@/assets/image/svg/rank/2nd.svg";
import RankThird from "@/assets/image/svg/rank/3rd.svg";
import UserDialog from "@/components/Common/UserDialog";
import ranking from "@/plugins/modules/ranking";
import favorite from "@/plugins/modules/favorite";

export default {
  components: {
    UserDialog,
    PawsIcon,
    RankFirst,
    RankSecound,
    RankThird,
  },
  auth: false,
  middleware: "update_user_status",
  created() {
    this.fetchRanking()
  },
  data () {
    return {
      dogRanking: [],
      dogInfo: {
        name: "バニラ",
        birthday: "2022年1月3日",
        dog_image1: "4.jpg",
        dog_image2: "1.jpg",
        dog_image3: "3.jpg",
        comment: "バニラ",
        twitter_id: "",
        instagram_id: "",
        tiktok_id: "",
        blog_id: "",
      },
      pages: "ranking",
      userDialog: false,
    };
  },
  computed: {
    groupedRanking() {
      return this.dogRanking.reduce((result, dog, index) => {
        const groupIndex = Math.floor(index / 3);
        if (!result[groupIndex]) {
          result[groupIndex] = [];
        }
        result[groupIndex].push(dog);
        return result;
      }, []);
    },
  },
  methods: {
    async fetchRanking() {
      if (this.$auth.loggedIn) {
        this.dogRanking = await ranking.getRankingWithFriends().then((response) => response)
      } else {
        this.dogRanking = await ranking.getRanking().then((response) => response)
      }
    },
    clickImage(index) {
      this.pages = "ranking";
      this.dogInfo = this.dogRanking[index];
      this.userDialog = true;
    },
    choiceClose() {
      this.userDialog = false;
    },
    addFavorite(friendId) {
      if (!this.$auth.loggedIn) {
        this.$router.push("/login");
      } else {
        favorite.addFavorite(friendId).then((response) => {
          this.findUserById(this.dogRanking, friendId, response);
        });
      }
    },
    deleteFavorite(friendId) {
      if (!this.$auth.loggedIn) {
        this.$router.push("/login");
      } else {
        favorite.deleteFavorite(friendId).then((response) => {
          this.findUserById(this.dogRanking, friendId, response);
        });
      }
    },
    findUserById(users, userId, response) {
      for (let i = 0; i < users.length; i++) {
        if (users[i].user_id === userId) {
          users[i] = response;
          this.dogInfo = response;
        }
      }
    },
    getImageUrl(image) {
      if (!image) {
        image = "1.jpg";
      }
      return `${process.env.imageBaseUrl}/${image}`;
    },
    getRankIcon(index) {
      if (index === 0) return "RankFirst";
      if (index === 1) return "RankSecound";
      if (index === 2) return "RankThird";
      return null;
    },
  },
};
</script>

<style scoped>

a {
  text-decoration: none;
}

p {
  font-size: 14px;
}

.all {
  min-width: 350px;
}

.headline-text {
  vertical-align: middle;
}

.ranking-col {
  position: relative;
}

.ranking-wrap {
  margin: 0 20px;
}

.headline-dog {
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: left;
  color: #505050;
}

.ranking-icon {
  position: absolute;
  z-index: 2;
  bottom: 35px;
  right: 15px
}

@media screen and (min-width: 600px) {
  .ranking-wrap {
      max-width: 600px;
      margin: 0 auto;
  }

  .ranking-icon {
      max-width: 60px;
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
