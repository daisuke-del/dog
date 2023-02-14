<template>
    <div class="all">
        <v-btn elevation="0" light class="ma-3" @click="logout">ログアウト</v-btn>
        <v-row>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[0]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[0].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[0].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[0].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[1]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[1].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[1].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[1].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[2]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[2].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[2].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[2].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[3]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[3].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[3].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[3].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[4]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[4].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[4].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[4].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[5]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[5].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[5].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[5].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[6]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[6].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[6].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[6].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[7]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[7].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[7].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[7].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[8]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[8].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[8].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[8].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[9]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[9].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[9].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[9].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[10]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[10].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[10].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[10].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[11]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[11].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[11].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[11].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[12]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[12].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[12].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[12].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[13]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[13].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[13].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[13].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[14]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[14].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[14].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[14].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[15]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[15].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[15].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[15].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[16]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[16].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[16].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[16].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[17]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[17].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[17].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[17].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[18]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[18].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[18].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[18].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
            <v-col cols="6" sm="4" md="3" lg="2">
                <v-card light max-width="200px" class="card" v-if="voidUsers[19]">
                    <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[19].face_image}`)" />
                    <div class="d-flex justify-center btn">
                        <v-btn elevation="0" @click="voidImage(voidUsers[19].user_id)">不正</v-btn>
                        <v-btn elevation="0" @click="notVoidImage(voidUsers[19].user_id)">問題なし</v-btn>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import admin from '@/plugins/modules/admin'
export default {
    name: 'AdminBackoffice',
    middleware: 'adminVerification',
    async asyncData({ app }) {
        if (!app.store.getters['adminInfo/login']) {
            app.router.replace('/login')
        }
        let voidUsers = []
        await admin.getVoidUsers().then((response) => {
            voidUsers = response;
        })
        return {
            voidUsers
        }
    },
    methods: {
        voidImage(userId) {
            admin.deleteVoidImage(userId).then(() => { })
        },
        notVoidImage(userId) {
            admin.updateYellowCard(userId).then(() => { })
        },
        logout() {
            admin.logout()
        }
    }
}
</script>

<style scoped>
.all {
    padding: 10px 20px;
    margin: 0 auto;
}
.btn {
    margin: 5px 2px;
}
</style>