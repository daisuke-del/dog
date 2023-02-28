<template>
    <div class="all">
        <support-dialog :dialog.sync="isShowModal" :content="content" @support-close="supportClose"/>
        <v-btn depressed light class="ma-3" @click="logout">ログアウト</v-btn>
        <v-card light>
            <v-tabs
            v-model="tab"
            fixed-tabs
            color="deep-purple-accent-4"
            align-tabs="center"
            >
                <v-tab value="voidUser" @click="clickVoidUser">不正画像ユーザー</v-tab>
                <v-tab value="support" @click="clickSupport">問い合わせ</v-tab>
            </v-tabs>
            <div
                v-if="isShowVoidUsers"
            >
                <v-row>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[0]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[0].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[0].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[0].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[1]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[1].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[1].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[1].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[2]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[2].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[2].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[2].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[3]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[3].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[3].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[3].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[4]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[4].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[4].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[4].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[5]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[5].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[5].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[5].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[6]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[6].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[6].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[6].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[7]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[7].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[7].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[7].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[8]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[8].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[8].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[8].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[9]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[9].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[9].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[9].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[10]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[10].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[10].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[10].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[11]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[11].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[11].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[11].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[12]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[12].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[12].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[12].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[13]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[13].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[13].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[13].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[14]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[14].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[14].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[14].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[15]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[15].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[15].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[15].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[16]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[16].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[16].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[16].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[17]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[17].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[17].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[17].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[18]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[18].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[18].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[18].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[19]">
                            <v-img :src="require(`@/../storage/image/faceimages/${voidUsers[19].face_image}`)" />
                            <div class="d-flex justify-center btn">
                                <v-btn depressed @click="voidImage(voidUsers[19].user_id)">不正</v-btn>
                                <v-btn depressed @click="notVoidImage(voidUsers[19].user_id)">問題なし</v-btn>
                            </div>
                        </v-card>
                    </v-col>
                </v-row>
            </div>
            <div
                v-else
            >
                <table>
                    <thead>
                        <tr>
                            <th>
                                ユーザー名
                            </th>
                            <th>
                                メールアドレス
                            </th>
                            <th>
                                問い合わせ項目
                            </th>
                            <th>
                                問い合わせ日
                            </th>
                            <th>
                                内容表示
                            </th>
                            <th>
                                解決
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in supports"
                            :key="index"
                        >
                            <td>{{ item.name }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.support_item }}</td>
                            <td>{{ item.created_at }}</td>
                            <td @click="showModal(item.support_content)" class="table-display">表示</td>
                            <td @click="clickResolve(item.id)" class="table-display">解決</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </v-card>
    </div>
</template>
<script>
import admin from '@/plugins/modules/admin'
import support from '@/plugins/modules/support'
import SupportDialog from '@/components/Support/SupportDialog'
export default {
    name: 'AdminBackoffice',
    components: { SupportDialog },
    middleware: 'adminVerification',
    async asyncData({ app }) {
        if (!app.store.getters['adminInfo/login']) {
            app.router.replace('/login')
        }
        let voidUsers = []
        let supports = []
        await admin.getInfo().then((response) => {
            voidUsers = response['voidUsers']
            supports = response['supports']

        })
        return {
            voidUsers,
            supports
        }
    },
    data() {
        return {
            tab: "support",
            isShowModal: false,
            isShowVoidUsers: true,
            content: ''
        }
    },
    methods: {
        voidImage(userId) {
            admin.deleteVoidImage(userId).then(() => { })
        },
        notVoidImage(userId) {
            admin.updateYellowCard(userId).then(() => { })
        },
        showModal(content) {
            this.content = content
            this.isShowModal = true
        },
        supportClose() {
            this.isShowModal = false
        },
        logout() {
            admin.logout()
        },
        clickVoidUser() {
            this.isShowVoidUsers = true;
        },
        clickSupport() {
            this.isShowVoidUsers = false;
        },
        clickResolve(id) {
            support.resolve(id)
        }
    }
}
</script>

<style scoped>
p {
    color: black;
}
.all {
    min-width: 800px;
    padding: 10px 20px;
    margin: 0 auto;
}
.btn {
    margin: 5px 2px;
}

thead,
tfoot {
    background-color: #3f87a6;
    color: #fff;
}

tbody {
    background-color: #e4f0f5;
}

caption {
    padding: 10px;
    caption-side: bottom;
}

table {
    border-collapse: collapse;
    border: 2px solid rgb(200, 200, 200);
    letter-spacing: 1px;
    font-family: sans-serif;
    font-size: 0.8rem;
}

td,
th {
    border: 1px solid rgb(190, 190, 190);
    padding: 5px 10px;
}

td {
    text-align: center;
}

.table-display {
    cursor: pointer;
}
</style>