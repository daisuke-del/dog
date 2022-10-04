<template>
  <div>
    <p class="big-text d-flex justify-center">顔写真をアップロード(必須)</p>
    <v-file-input
      v-model="file"
      chips
      label="アップロード"
      class="upload-wrap"
      @change="onImagePicked"
    ></v-file-input>
    <div class="btn-wrap">
      <button class="back-btn">戻る</button>
      <button class="next-btn">次へ</button>
    </div>
    <div v-if="file" class="preview-wrap">
      <p class="small-text">画像プレビュー</p>
      <img :src="uploadImageUrl" class="my-img" />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      file: null,
      uploadImageUrl: '',
    }
  },
  methods: {
    onImagePicked(file) {
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
    },
  },
}
</script>

<style scoped>
.big-text {
  font-size: 1.5em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.small-text {
  font-size: 1em;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.upload-wrap {
  margin-top: 30px;
}

.my-img {
  max-width: 200px;
}

.preview-wrap {
  margin-top: 10px;
  text-align: center;
}

.btn-wrap {
  text-align: center;
  margin-right: 20px;
}

.next-btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
  background-color: white;
  width: 100px;
  height: 30px;
  border-radius: 0.3em;
  outline: 1px solid #b9c9ce;
  margin: 30px 0 15px 15px;
}

.back-btn {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  color: slategray;
  background-color: white;
  width: 100px;
  height: 30px;
  border-radius: 0.3em;
  outline: 1px solid #b9c9ce;
  margin: 30px 0 15px 15px;
}

.next-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

.back-btn:hover {
  outline: none;
  border: 2px solid #b9c9ce;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2em;
  }
}
</style>
