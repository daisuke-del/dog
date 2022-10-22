<template>
  <div>
    <div class="face-image">
      <label class="btn mt-2 mb-4">
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
          :rotatable="false"
          :src="imgSrc"
          alt="Source Image"
          :img-style="{ 'width': '300px', 'height': '300px', 'border': '2px solid #f4f4f4', 'border-radius': '10px', 'background-color': '#f4f4f4' }"
          :aspect-ratio="1"
        />
      </div>
      <img
        v-show="cropImg"
        :src="cropImg"
        alt="Cropped Image"
        class="crop-img"
      >
      <div class="btn-wrap">
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
      drawer: true
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
      this.$emit('store-face-image', this.cropImg)
    },
    clickBack () {
      this.$emit('click-back', 1)
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