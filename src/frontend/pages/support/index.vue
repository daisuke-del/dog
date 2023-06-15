<template>
    <div class="support-wrap mt-10 mx-auto">
        <h1 class="mb-6">サポート</h1>
        <p>全てのお問い合わせに返信は行なっておりません。</p>
        <p class="mb-6">
            返信が必要なお問い合い合わせに関しては、ご入力いただいたメールアドレスにご連絡させていただきます。
        </p>
        <v-form ref="supportForm">
            <div class="main-wrap">
                <v-text-field v-model="name" :rules="nameRules" label="お名前" background-color="white" required outlined
                light />
                <v-text-field v-model="email" :rules="emailRules" label="メールアドレス" background-color="white" required outlined
                light class="mb-6" />
                <div>
                    <h3>問い合わせ項目</h3>
                    <v-select
                        light
                        outlined
                        v-model="item"
                        background-color="white"
                        :items="inquiryItems"
                        :rules="inquiryItemRules"
                        class="mb-6"
                    />
                    <h3>問い合わせ内容</h3>
                    <v-textarea
                        light
                        outlined
                        background-color="white"
                        v-model="content"
                        :rules="inquiryContentRules"
                        class="mb-6"
                    ></v-textarea>
                </div>
                <v-tooltip v-model="showSupportTooltip" top>
                  <template v-slot:activator="{ attrs }">
                    <v-btn block height="40px" depressed color="#fd7e00" :loading="supportLoading" class="font-weight-bold mb-8"  v-bind="attrs" @click="sendSupport">
                      送信
                    </v-btn>
                  </template>
                  <span>送信しました</span>
                </v-tooltip>
            </div>
        </v-form>
    </div>
  </template>
  <script>
  import support from '@/plugins/modules/support'
  import constants from '@/utils/constants'
  export default {
    name: 'SupportForm',
    auth: false,
    data() {
      return {
        name: null,
        email: null,
        nameRules: [
          v => !!v || '名前が入力されていません。',
        ],
        emailRules: [
          v => !!v || 'メールアドレスが入力されていません。',
          v => v == null || v.match(constants.mailValidation) != null || 'メールアドレスの形式ではありません。',
        ],
        inquiryItemRules: [
          v => !!v || 'お問い合わせ項目が選択されていません。',
        ],
        inquiryContentRules: [
          v => !!v || 'お問い合わせ内容が記載されていません。',
        ],
        supportLoading: false,
        inquiryItems: [
            '不具合',
            'その他'
        ],
        item: null,
        content: null,
        showSupportTooltip: false
      }
    },
    methods: {
      async sendSupport() {
        if (this.$refs.supportForm.validate()) {
          this.supportLoading = true
          await support.send(this.name, this.email, this.item, this.content).then(() => {
            this.$refs.supportForm.reset()
            window.alert('送信が完了しました。')
          }).finally(() => {
            this.supportLoading = false
          });
        }
      }
    }
  }
  </script>

  <style scoped>
  h1 {
    font-family: 'Rampart One', cursive;
    color: dimgrey;
    margin: 20px;
    text-align: center;
  }

  h3 {
    color: dimgrey;
  }

  p {
    color: black;
  }

  .support-wrap {
    padding: 10px 20px;
    max-width: 600px;
  }
  </style>