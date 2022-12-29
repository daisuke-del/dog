<template>
    <div>
        <v-list-item-avatar>
            <v-img :src="require('@/../../storage/image/faceimages/no-user-image-icon.jpeg')" />
        </v-list-item-avatar>

        <v-list-item-content>
            <v-list-item-title>Guest</v-list-item-title>
        </v-list-item-content>
    </div>
</template>

<script>
export default {
    name: 'GuestAvatar'
}
</script>