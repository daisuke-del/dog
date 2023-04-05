<template>
  <div>
    <p class="warn-text mb-1">登録した写真はアプリ内で公開されます</p>
    <p class="warn-text">サイズの大きい画像は登録できない場合がございます</p>
    <div class="face-image">
      <label  v-if="!cropImg" class="btn mt-2 mb-4">
        <input
          type="file"
          name="image"
          accept="image/*"
          class="input-box"
          @change="setImage"
        >
        <v-icon color="white"> mdi-image-multiple </v-icon>
        写真を選ぶ
      </label>
      <label  v-else class="btn mt-2 mb-4">
        <input
          type="file"
          name="image"
          accept="image/*"
          class="input-box"
          @change="setImageAgain"
        >
        <v-icon color="white"> mdi-image-multiple </v-icon>
        写真を選びなおす
      </label>
      <div
        v-show="!cropImg"
        class="crop-area"
      >
        <vue-cropper
          ref="cropper"
          :guides="true"
          :view-mode="1"
          drag-mode="crop"
          :background="true"
          :src="imgSrc"
          alt="Source Image"
          :img-style="{ 'width': '300px', 'height': '300px', 'border': '2px solid #f4f4f4', 'border-radius': '10px', 'background-color': '#f4f4f4' }"
          :aspect-ratio="1"
        />
      </div>
      <div v-show="cropImg" class="crop-img">
        <v-img
          :src="cropImg"
          alt="Cropped Image"
        />
      </div>
      <div class="pt-4 pb-4" v-if="ajustBtn">
        <v-row>
          <v-col cols="4">
            <v-btn @click.prevent="zoom(0.2)">
              <v-icon>
                mdi-plus
              </v-icon>
            </v-btn>
          </v-col>
          <v-col cols="4">
            <v-btn @click.prevent="zoom(-0.2)">
              <v-icon>
                mdi-minus
              </v-icon>
            </v-btn>
          </v-col>
          <v-col cols="4">
            <v-btn @click.prevent="move(0, -10)">
              <v-icon>
                mdi-arrow-up-thin
              </v-icon>
            </v-btn>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="4">
            <v-btn @click.prevent="move(-10, 0)">
              <v-icon>
                mdi-arrow-left-thin
              </v-icon>
            </v-btn>
          </v-col>
          <v-col cols="4">
            <v-btn @click.prevent="move(10, 0)">
              <v-icon>
                mdi-arrow-right-thin
              </v-icon>
            </v-btn>
          </v-col>
          <v-col cols="4">
            <v-btn @click.prevent="move(0, 10)">
              <v-icon>
                mdi-arrow-down-thin
              </v-icon>
            </v-btn>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="4">
            <v-btn @click.prevent="rotate(-90)">
              <v-icon>
                mdi-restore
              </v-icon>
            </v-btn>
          </v-col>
          <v-col cols="4">
            <v-btn @click.prevent="rotate(90)">
              <v-icon>
                mdi-reload
              </v-icon>
            </v-btn>
          </v-col>
          <v-col cols="4">
            <v-btn @click="clickOk">
              決定
            </v-btn>
          </v-col>
        </v-row>
      </div>
      <div v-else class="btn-wrap">
        <v-btn
          v-if="imgSrc != '' && !cropImg"
          block
          color="primary"
          height="50px"
          class="btn mt-2 mb-2"
          @click="clickAjust"
        >
          画像を調整する
        </v-btn>
        <v-btn
          v-if="imgSrc != '' && !cropImg"
          dark
          block
          depressed
          color="#0055ff"
          height="50px"
          class="btn mt-3 mb-3"
          @click="cropImage"
        >
          切り取る
        </v-btn>
        <v-row v-else-if="cropImg" class="mt-1 mb-1">
          <v-col cols="6">
            <v-btn
              dark
              block
              depressed
              color="#0055ff"
              height="50px"
              class="btn"
              @click="changeImgSrc"
            >
              やりなおし
            </v-btn>
          </v-col>
           <v-col cols="6">
            <v-btn
              dark
              block
              depressed
              color="primary"
              height="50px"
              class="btn"
              @click="saveCropImage"
            >
              決定
            </v-btn>
          </v-col>
        </v-row>
        <v-btn
          v-else
          block
          depressed
          color="#c4c4c4"
          height="50px"
          class="btn mt-2 mb-2"
        >
          写真を未選択
        </v-btn>
        <v-btn
          block
          depressed
          color="#c4c4c4"
          height="50px"
          class="btn mt-2 mb-2"
          @click="clickBack"
        >
          戻る
        </v-btn>
      </div>
    </div>
  </div>
</template>

<script>
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";
export default {
  name: 'CommonCropper',
  components: {
    VueCropper
  },
  data () {
    return {
      imgSrc: "",
      cropImg: "",
      drawer: true,
      ajustBtn: false
    }
  },
  methods: {
    setImage (e) {
      const file = e.target.files[0];
      if (!file.type.includes("image/")) {
        alert("Please select an image file");
        return;
      }
      if (typeof FileReader === "function") {
        const reader = new FileReader();
        reader.onload = event => {
          this.imgSrc = event.target.result;
          // rebuild cropperjs with the updated source
          this.$refs.cropper.replace(event.target.result);
        };
        reader.readAsDataURL(file);
      } else {
        alert("Sorry, FileReader API not supported");
      }
    },
    setImageAgain (e) {
      this.cropImg = ''
      const file = e.target.files[0];
      if (!file.type.includes("image/")) {
        alert("Please select an image file");
        return;
      }
      if (typeof FileReader === "function") {
        const reader = new FileReader();
        reader.onload = event => {
          this.imgSrc = event.target.result;
          // rebuild cropperjs with the updated source
          this.$refs.cropper.replace(event.target.result);
        };
        reader.readAsDataURL(file);
      } else {
        alert("Sorry, FileReader API not supported");
      }
    },
    cropImage () {
      // get image data for post processing, e.g. upload or setting image src
      this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
    },
    changeImgSrc () {
      this.cropImg = ''
    },
    closeImgModal () {
      this.$emit('close-image-modal')
    },
    saveCropImage () {
      this.$emit('store-face-image', this.cropImg)
    },
    clickBack () {
      this.$emit('click-back', 1)
    },
    clickAjust () {
      if (this.imgSrc) {
        this.ajustBtn = true
      }
    },
    clickOk () {
      this.ajustBtn = false
    },
    zoom(percent) {
      this.$refs.cropper.relativeZoom(percent);
    },
    move(offsetX, offsetY) {
      this.$refs.cropper.move(offsetX, offsetY);
    },
    rotate(deg) {
      this.$refs.cropper.rotate(deg);
    }
  }
}
</script>

<style scoped>
label {
    padding: 12px;
    color: #ffffff;
    background-color: #384878;
    cursor: pointer;
    display: block;
    width: 300px;
    margin: 0 auto;
    border-radius: 3px;
}

input[type="file"] {
    display: none;
}


.warn-text {
  color: red;
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 11px;
  font-weight: bold;
  text-align: center;
}

.input-box {
  color: black;
  font-size: 16px;
  padding: 10px 0;
}

.face-image {
  text-align: center;
}

.crop-area {
  width: 300px;
  height:300px;
  display: inline-block;
}

.crop-img {
  width: 300px;
  height:300px;
  border: none;
  display: inline-block;
}

.btn-wrap {
  width: 300px;
  margin: 0 auto;
}

.btn {
  font-size: 16px;
  font-weight: bolder;
}
</style>