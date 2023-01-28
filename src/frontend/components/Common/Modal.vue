<template>
  <div id="modal">
    <div id="modal-content" class="modal">
      <v-card light width="300px">
        <v-img
            :src="require(`@/../storage/image/faceimages/${modalUser.faceImage}`)"
            contain
        />
        <div class="mt-3 text-wrap">
          <p class="card-text mb-2">名前：{{ modalUser.name}}</p>
          <p class="card-text mb-2">年収：約{{ modalUser.salary }}万円</p>
          <p class="card-text mb-2">身長：{{ modalUser.height }}cm</p>
        </div>
        <div class="icon-wrap my-2">
          <v-btn icon class="mx-2" :disabled="!modalUser.twitterId" @click="clickTwitter(modalUser.twitterId)">
            <v-icon large color="#1DA1F2">
              mdi-twitter
            </v-icon>
          </v-btn>
          <v-btn icon class="mx-2" :disabled="!modalUser.instagramId" @click="clickInstagram(modalUser.instagramId)">
            <v-icon large color="#C13584">
              mdi-instagram
            </v-icon>
          </v-btn>
          <v-btn icon class="mx-2" :disabled="!modalUser.facebookId" @click="clickFacebook(modalUser.facebookId)">
            <v-icon large color="#4267B2">
              mdi-facebook
            </v-icon>
          </v-btn>
        </div>
        <v-btn class="mt-2 mb-4" @click="closeCard">閉じる</v-btn>
      </v-card>
    </div>
    <div id="modal-overlay" @click="closeCard"></div>
  </div>
</template>

<script>
export default {
  name: "PartsModal",
  props: {
    modalUser: {
      type: Object
    }
  },
  methods: {
    closeCard() {
      this.$emit("summary-method", false);
    },
    clickTwitter(url){
      window.open(url, '_blank')
    },
    clickInstagram(url){
      window.open(url, '_blank')
    },
    clickFacebook(url){
      window.open(url, '_blank')
    },
  },
};
</script>

<style scoped>
.modal {
  z-index: 2;
  text-align: center;
  position: fixed;
  Top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

#modal-overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: center;
  background-color: #696969da;
  z-index: 1;
}

.card-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}
</style>