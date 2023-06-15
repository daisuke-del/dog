<template>
  <div id="modal">
    <div id="modal-content" class="modal">
      <p class="upload-text">写真をアップロード</p>
      <v-file-input
          v-model="file"
          chips
          label="アップロード"
          class="upload-wrap"
          @change="onImagePicked"
      ></v-file-input>
      <button class="modal__btn" @click="returnTrue()">写真を変更</button>
      <button class="modal__btn" @click="returnFalse()">キャンセル</button>
    </div>
    <div id="modal-overlay"></div>
  </div>
</template>

<script>
export default {
  name: 'PartsModalfile',
  props: {
    imageNumber: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      file: null,
      uploadImageUrl: ''
    }
  },
  methods: {
    returnFalse () {
      this.$emit("execute-method", false);
    },
    returnTrue () {
      this.$emit("execute-method", true);
    },
    onImagePicked (file) {
      if (file !== undefined && file !== null) {
        if (file.name.lastIndexOf('.') <= 0) {
          return
        }
        const fr = new FileReader()
        fr.readAsDataURL(file)
        fr.addEventListener('load', () => {
          this.uploadImageUrl = fr.result
        })
      } else {
        this.uploadImageUrl = ''
      }
    }
  }
}
</script>
<style scoped>
.upload-text {
  font-family: 'Noto Sans JP', sans-serif;
  color: black;
  margin-top: 20px;
}

.modal {
  padding: 10px 20px;
  background: #faebd7;
  z-index: 2;
  display: block;
  text-align: center;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  border-radius: 10px;
}

.modal-btn {
  display: inline-block;
  width: 80px;
  height: 30px;
  margin-right: 5px;
  margin-left: 5px;
  border-radius: 3px;
  transition: 0.4s;
  text-align: center;
  vertical-align: middle;
  font-size: 15px;
  font-family: 'Noto Sans JP', sans-serif;
  color: black;
}

.modal-btn:hover {
  background: #a5272a;
  color: white;
  cursor: pointer;
}

#modal-overlay {
  z-index: 1;
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 120%;
}
</style>