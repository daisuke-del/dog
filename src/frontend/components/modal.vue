<template>
  <div id="modal">
    <div id="modal-content" class="modal">
      <v-card>
        <v-img
            :src='"~/faceimages/nface_image/mface_image/" + this.n + ".jpeg"'
            height="300px"
            contain
        />
        <p class="name-text">田中タロウ</p>
        <p class="name-text">身長：180cm</p>
        <p class="salary-text">年収：500万円</p>
        <div class="icon-wrap">
          <v-btn
              icon
          >
            <v-icon
                size="2em"
            >
              mdi-twitter
            </v-icon>
          </v-btn>
          <v-btn
              icon
          >
            <v-icon
                size="2em"
            >
              mdi-instagram
            </v-icon>
          </v-btn>
          <v-btn
              icon
          >
            <v-icon
                size="2em"
            >
              mdi-facebook
            </v-icon>
          </v-btn>
        </div>
        <button class="modal__btn" @click="closeCard()">閉じる</button>
      </v-card>
    </div>
    <div id="modal-overlay"></div>
  </div>
</template>

<script>
export default {
  name: "PartsModal",
  props: {
    n: Number
  },
  methods: {
    closeCard() {
      this.$emit("summary-method", false);
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

.modal-btn {
  display: inline-block;
  margin: 30px auto;
  text-decoration: none;
  width: 80px;
  height: 30px;
  border-radius: 3px;
  transition: 0.4s;
  text-align: center;
  vertical-align: middle;
  font-size: 15px;
  font-family: 'Noto Sans JP', sans-serif;
}

#modal-overlay {
  z-index: 1;
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.name-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
  margin-top: 16px;
}

.salary-text {
  font-size: 1.2em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}
</style>