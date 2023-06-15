<template>
  <div>
    <v-select
      v-model="item"
      :items="itemList"
      :label="itemLabel"
      class="select"
      item-text="name"
      item-value="value"
      outlined
      dense
      hide-details
      @change="onChange"
    />
  </div>
</template>

<script>
export default {
  props: {
    itemList: {
      type: Array,
      required: true
    },
    selectItem: {
      type: Object,
      required: true
    },
    itemLabel: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      item: this.selectItem
    }
  },
  watch: {
    selectItem (newValue) {
      this.item = newValue
    }
  },
  methods: {
    onChange (value) {
      this.$emit('changeItem', value)
    }
  }
}
</script>

<style scoped>
.select {
  background-color: white;
}
</style>