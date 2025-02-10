<template>
  <v-dialog
    :value="dialog"
    @input="$emit('update:dialog', $event)"
    width="400"
  >
  <v-card light>
    <v-card-title class="text-h7 grey lighten-2">
      犬以外が表示されている？
    </v-card-title>

    <v-card-text>
      画像が犬でなければ『犬ではない！』をクリック
    </v-card-text>
    <v-img :src="getImageUrl(dogImage)" />

    <v-divider />

    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
        class="btn-text"
        color="accent"
        @click="alertClick"
      >
        犬ではない！
      </v-btn>
      <v-btn
        class="btn-text"
        @click="choiceClose"
      >
        キャンセル
      </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
name: 'ChoiceDialog',
props: {
dialog: {
type: Boolean,
default: false
},
dogImage: {
type: String,
default: 'no-user-image-icon.png'
},
isLeft: {
type: Boolean,
require: true
}
},
computed: {
changeDialog () {
return this.dialog
}
},
methods: {
alertClick () {
if (this.isLeft) {
this.$emit('left-click')
} else {
this.$emit('right-click')
}
},
choiceClose () {
this.$emit('choice-close')
},
getImageUrl(image) {
if (!image) {
image = '1.jpg';
}
return `${process.env.imageBaseUrl}/${image}`;
},
}
}
</script>

<style scoped>
.v-card__text {
margin-top: 30px;
}

.btn-text {
font-weight: bold;
}
</style>