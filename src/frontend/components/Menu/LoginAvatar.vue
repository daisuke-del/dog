<template>
    <div>
        <v-list-item-avatar>
            <v-img :src="require('@/storage/image/faceimages/99.jpeg')" />
        </v-list-item-avatar>

        <v-list-item-content>
            <v-list-item-title>Name</v-list-item-title>
        </v-list-item-content>
    </div>
</template>

<script>
export default {
    name: 'LoginAvatar'
}
</script>