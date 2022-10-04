<template>
  <div>
    <p class="big-text d-flex justify-center">顔写真をアップロード(必須)</p>
    <div>
      <input type="file" ref="preview" @change="uploadFile" />
    </div>
    <div v-if="url">
      <div style="position: absolute" @click="deletePreview">X</div>
      <img :src="url" class="my-img" />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      url: '',
    }
  },
  methods: {
    uploadFile() {
      const file = this.$refs.preview.files[0]
      this.url = URL.createObjectURL(file)
    },
    deletePreview() {
      this.url = ''
      URL.revokeObjectURL(this.url)
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

.my-img {
  max-height: 400px;
}

@media screen and (min-width: 600px) {
  .big-text {
    font-size: 2em;
  }
}
</style>
