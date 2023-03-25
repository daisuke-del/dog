<template>
  <div>
    <v-sheet
      class="modal-overlay"
    >
      <div class="modal">
        <v-icon
          class="delete-icon"
          size="30px"
          color="accent"
          @click="closeImgModal"
          >
          mdi-close-thick
        </v-icon>
        <h1>写真をアップロード</h1>
        <label class="btn mt-4 mb-4">
          <input
            type="file"
            name="image"
            accept="image/*"
            style="color: black; font-size: 1.2em; padding: 10px 0;"
            @change="setImage"
          >
          <v-icon color="white"> mdi-image-multiple </v-icon>
          写真を選ぶ
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
        <v-img
          v-show="cropImg"
          :src="cropImg"
          alt="Cropped Image"
          class="crop-img"
        />
        <div v-if="ajustBtn">
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
            class="btn mt-2 mb-2"
            @click="cropImage"
          >
            切り取る
          </v-btn>
          <v-btn
            v-else-if="cropImg"
            dark
            block
            depressed
            color="#4bb543"
            height="50px"
            class="btn mt-2 mb-2"
            @click="saveCropImage"
          >
            決定
          </v-btn>
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
            v-if="cropImg"
            light
            block
            depressed
            color="#ffbb33"
            height="50px"
            class="btn mt-2 mb-2"
            @click="changeImgSrc"
          >
            やりなおし
          </v-btn>
        </div>
      </div>
    </v-sheet>
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
      this.$emit('save-crop-image', this.cropImg)
    },
    clickAjust () {
      this.ajustBtn = true
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
h1 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
}

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

.modal-overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: center;
  background-color: #000000da;
  z-index: 5;
}

.modal {
  position: relative;
  text-align: center;
  width: 600px;
  height: 600px;
  margin-top: 10%;
  padding: 30px 0;
  border-radius: 20px;
  background: url("~/assets/image/backGrounds/default750.png") top center no-repeat;
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
.delete-icon {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 2%;
  right: 3%;
  background-size: contain;
  z-index: 10;
}
</style>