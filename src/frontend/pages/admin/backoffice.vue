<template>
    <div class="all">
        <support-dialog
            :dialog.sync="isShowModal"
            :content="content"
            @support-close="supportClose"
        />
        <image-dialog
            :dialog.sync="imageDialog"
            :dog-info="dogInfo"
            @choice-close="choiceClose"
        />
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
            <div v-if="isShowVoidUsers">
                <v-row>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[0]" @click="clickCard(voidUsers[0])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[0].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[1]" @click="clickCard(voidUsers[1])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[1].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[2]" @click="clickCard(voidUsers[2])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[2].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[3]" @click="clickCard(voidUsers[3])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[3].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[4]" @click="clickCard(voidUsers[4])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[4].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[5]" @click="clickCard(voidUsers[5])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[5].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[6]" @click="clickCard(voidUsers[6])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[6].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[7]" @click="clickCard(voidUsers[7])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[7].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[8]" @click="clickCard(voidUsers[8])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[8].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[9]" @click="clickCard(voidUsers[9])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[9].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[10]" @click="clickCard(voidUsers[10])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[10].dog_image1}`" />
                        </v-card>
                    </v-col>
                    <v-col cols="6" sm="4" md="3" lg="2">
                        <v-card light max-width="200px" class="card" v-if="voidUsers[11]" @click="clickCard(voidUsers[11])">
                            <v-img :src="`http://dogiland.jp/storage/${voidUsers[11].dog_image1}`" />
                        </v-card>
                    </v-col>
                </v-row>
            </div>
            <div v-else>
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
import ImageDialog from '@/components/Support/ImageDialog'
export default {
    name: 'AdminBackoffice',
    components: { SupportDialog, ImageDialog },
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
            content: '',
            imageDialog: false,
            dogInfo: {
                name: 'バニラ',
                dog_image1: '4.jpg',
                dog_image2: '1.jpg',
                dog_image3: '3.jpg',
                comment: 'バニラ',
                breed1: '',
                breed2: '',
                twitter_id: '',
                instagram_id: '',
                tiktok_id: '',
                blog_id: ''
            }
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
        },
        clickCard (dogInfo) {
            this.dogInfo = dogInfo
            this.imageDialog = true
        },
        choiceClose () {
            this.imageDialog = false
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
    padding: 20px;
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