<template>
  <v-container>
    <h2>人物登録フォーム</h2>

    <v-form ref="form" @submit.prevent="submit">
      <v-text-field v-model="form.name" label="名前" required />
      <v-textarea v-model="form.comment" label="コメント" rows="4" required />
      <v-file-input v-model="form.image" label="画像ファイル" accept="image/*" required />

      <v-btn color="primary" type="submit">作成</v-btn>
    </v-form>

    <div v-if="generatedUrl" class="mt-5">
      <p>発行された診断URL：</p>
      <a :href="generatedUrl" target="_blank">{{ generatedUrl }}</a>
    </div>
  </v-container>
</template>

<script>
export default {
  auth: false,
  data() {
    return {
      form: {
        name: '',
        comment: '',
        image: null,
      },
      generatedUrl: null,
    }
  },
  methods: {
    async submit() {
      const formData = new FormData()
      formData.append('name', this.form.name)
      formData.append('comment', this.form.comment)
      formData.append('image', this.form.image)

      try {
        const res = await this.$axios.$post('/api/diagnosis/person', formData)
        this.generatedUrl = `/diagnosis/love/${res.slug}`
      } catch (e) {
        alert('登録に失敗しました')
      }
    }
  }
}
</script>
