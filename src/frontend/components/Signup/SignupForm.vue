<template>
  <div>
    <v-form ref="signupForm" class="signup-form-wrap">
      <v-container fluid>
        <p>性別選択</p>
        <v-radio-group
          v-model="sex"
          mandatory
          row
          hide-details
        >
          <v-radio
            label="おんなのこ"
            value="female"
          />
          <v-radio
            label="おとこのこ"
            value="male"
          />
        </v-radio-group>
      </v-container>
      <div class="main-wrap">
        <v-text-field
          v-model="name"
          label="わんちゃんの名前"
          required
          light
          :rules="nameRules"
          :counter="10"
          class="name form-content"
        />
        <v-text-field
          v-model="email"
          :rules="emailRules"
          class="mail form-content"
          label="メールアドレス(example@gmail.com)"
          required
          light
        />
        <v-text-field
          v-model="password"
          :rules="passwordRules"
          :append-icon="isShowPassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="isShowPassword ? 'text' : 'password'"
          class="password form-content"
          label="パスワード"
          required
          light
        />
        <v-card class="fullyear mb-5" elevation="0">
          <p class="mb-4">生年月日</p>
          <v-card-text class="pt-0">
            <v-row>
              <v-col cols="6">
                <v-select
                  v-model="year"
                  :items="years"
                  label="西暦"
                  outline
                  hide-details
                  @change="resetDay"
                />
              </v-col>
              <v-col cols="3">
                <v-select
                  v-model="month"
                  :items="months"
                  label="月"
                  outline
                  hide-details
                  @change="resetDay"
                />
              </v-col>
              <v-col cols="3">
                <v-select
                  v-model="day"
                  :items="days"
                  label="日"
                  outline
                  hide-details
                />
              </v-col>
            </v-row>
          </v-card-text>
          <p v-if="birthdayErrorShow" class="error-message">
            生年月日の内容が不正です。
          </p>
        </v-card>
        <label>
          <span>
            <v-select
              v-model="itemBreed1"
              :items="breedRange"
              :rules="breedRules"
              label="犬種を選択"
              outlined
              required
              class="mt-10"
            />
          </span>
        </label>
        <label>
          <span v-if="isMix">
            <v-select
              v-model="itemBreed2"
              :items="breedRange"
              label="犬種を選択"
              outlined
            />
          </span>
        </label>
        <v-btn
          v-if="!isMix"
          outlined
          class="mb-5 btn"
          @click="clickMix"
        >
          ミックス
        </v-btn>
        <v-btn
        v-if="isMix"
          outlined
          class="mb-5 btn"
          @click="closeMix"
        >
          <v-icon>
            mdi-close
          </v-icon>
        </v-btn>
        <p v-if="breedErrorShow" class="error-message">
          犬種を選択してください。
        </p>
        <div class="form-content d-flex mt-5 mb-0">
          <label>
            <span>体重</span>
            <input
              v-for="(input, index) in 2"
              :id="generateInputNum('weight', index)"
              :ref="generateInputNum('weight', index)"
              :key="'weight' + index" v-model="weightValues[index]"
              class="number"
              type="tel"
              maxlength="1"
              autocomplete="off"
              required
              oninput="value = value.replace(/[^0-9]+/i,'');" @keyup="weightHandleInputFocus(index, $event)">
            <span>kg</span>
          </label>
        </div>
        <p v-if="weightErrorShow" class="error-message">
          体重は2桁の半角数字で入力してください。例:06
        </p>
        <label class="form-content">
          <span>
            <v-select
              v-model="location"
              class="mt-10"
              :items="prefectureRange"
              :rules="locationRules"
              label="居住場所を選択"
              outlined
              required
            />
          </span>
        </label>
        <div class="pt-5 pb-5">
          <div>
            <span class="text-label mr-2">任意</span>
            <p class="text-sns mb-0">Instagramアカウントを登録</p>
            <v-text-field
              v-model="inputInstagram"
              placeholder="InstagramのIDを入力"
              autocomplete="off"
              hide-details
              class="form-content"
            />
          </div>
          <div>
            <span class="text-label mr-2">任意</span>
            <p class="text-sns mb-0">Twitterアカウントを登録</p>
            <v-text-field
              v-model="inputTwitter"
              placeholder="TwitterのIDを入力"
              autocomplete="off"
              hide-details
              class="form-content"
            />
          </div>
          <div>
            <span class="text-label mr-2">任意</span>
            <p class="text-sns mb-0">Tiktokアカウントを登録</p>
            <v-text-field
              v-model="inputTiktok"
              placeholder="TiktokのIDを入力"
              autocomplete="off"
              hide-details
              class="form-content"
            />
          </div>
          <div>
            <span class="text-label mr-2">任意</span>
            <p class="text-sns mb-0">Blogアカウントを登録</p>
            <v-text-field
              v-model="inputBlog"
              placeholder="BlogのURLを入力"
              autocomplete="off"
              hide-details
              class="form-content"
            />
          </div>
        </div>
        <div class="support-wrap d-flex justify-center">
          <v-btn
            text
            to="/support/terms"
            target="_blank"
            class="small-text"
          >
            利用規約を確認
          </v-btn>
        </div>
        <div class="d-flex justify-center">
          <v-checkbox
            v-model="checkbox"
            label="利用規約に同意します"
            required
            light
            hide-details=false
            class="checkbox"
          />
        </div>
        <p v-if="agreeErrorShow" class="error-message">
          利用規約に同意が必須です。
        </p>
        <v-btn
          :loading="sendLoading"
          block
          dark
          height="40px"
          depressed
          color="primary"
          class="font-weight-bold mt-4"
          @click="storeUserInfo"
        >
          入力項目を送信
        </v-btn>
      </div>
    </v-form>
  </div>
</template>

<script>
import constants from '@/utils/constants'
export default {
  name: 'SignupForm',
  props: {
    sendLoading: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      sex: 'female',
      name: null,
      email: null,
      password: null,
      isShowPassword: true,
      weightValues: [0],
      select: null,
      checkbox: null,
      title: 'わんちゃん登録',
      breedRange: [
        '雑種',
        'アイリッシュセター',
        'アフガンハウンド',
        'アメリカンコッカースパニエル',
        'イタリアングレーハウンド',
        'イングリッシュコッカースパニエル',
        'イングリッシュセター',
        'ウィペット',
        'ウエストハイランドホワイトテリア',
        'ウエストハイランドホワイトテリア',
        'ウエルシュコーギーカーディガン',
        'ウエルシュコーギーペンブローク',
        'ウェルシュテリア',
        'エアデールテリア',
        'オールドイングリッシュシープドック',
        'カニンヘンダックスフンド',
        'キャバリア',
        'グレートデン',
        'グレートピレニーズ',
        'グレーハウンド',
        'ケアーンテリア',
        'ゴールデンレトリバー',
        'サモエド',
        'シーズー',
        'シーリハムテリア',
        'シェットランドシープドッグ',
        'シェトランドシープドック',
        'シベリアンハスキー',
        'シャーペイ',
        'ジャーマンシェパード',
        'ジャイアントシュナウザー',
        'ジャックラッセルテリア',
        'スキッパーキ',
        'スコティッシュテリア',
        'スタンダードダックスフンドシュナウザー',
        'スムースコリー',
        'セントバーナード',
        'タイニープードル',
        'ダックスフンド',
        'ダルメシアン',
        'チベタンスパニエル',
        'チャイニーズ・クレステッド・ドッグ',
        'チャウチャウ',
        'チワワ',
        'ドーベルマンピンシャー',
        'トイプードル',
        'トイマンチェスターテリア',
        'ノーフォークテリア',
        'ノーリッチテリア',
        'バーニーズマウンテンドック',
        'パグ',
        'バセンジー',
        'パピヨン',
        'ビーグル',
        'ビジョンフリーゼ',
        'プチブラバンソン',
        'ブリュッセルグリフォン',
        'ブルテリア',
        'フレンチブルドッグ',
        'ペキニーズ',
        'ベルジアングリフォン',
        'ボーダーコリー',
        'ポインター',
        'ボクサー',
        'ボストンテリア',
        'ポメラニアン',
        'ボルゾイ',
        'ボロニーズ',
        'マスティフ',
        'マルチーズ',
        'マンチェスターテリア',
        'ミニチュアシュナウザー',
        'ミニチュアダックスフンド',
        'ミニチュアピンシャー',
        'ミニチュアプードル',
        'ミニチュアブルテリア',
        'ヨークシャテリア',
        'ラフコリー',
        'ラブラドールレトリバー',
        'ロットワイラー',
        'ワイマラナー',
        'ワイヤーフォックステリア',
        '四国犬',
        '土佐犬',
        '日本スピッツ',
        '柴犬',
        '狆(チン)',
        '甲斐犬',
        '秋田犬',
        '紀州犬',
        '豆柴'
      ],
      prefectureRange: [
      "北海道","青森県","岩手県","宮城県","秋田県","山形県","福島県","茨城県","栃木県","群馬県","埼玉県","千葉県","東京都","神奈川県","新潟県","富山県","石川県","福井県","山梨県","長野県","岐阜県","静岡県","愛知県","三重県","滋賀県","京都府","大阪府","兵庫県","奈良県","和歌山県","鳥取県","島根県","岡山県","広島県","山口県","徳島県","香川県","愛媛県","高知県","福岡県","佐賀県","長崎県","熊本県","大分県","宮崎県","鹿児島県","沖縄県"
      ],
      itemBreed1: null,
      itemBreed2: null,
      item: null,
      salary: null,
      nameRules: [
        v => !!v || 'なまえは必須項目です',
        v => v == null || (v.length <= constants.maxNameLength) || 'なまえは10文字以内で入力して下さい。'
      ],
      emailRules: [
        v => !!v || 'メールアドレスが入力されていません。',
        v => v == null || v.match(constants.mailValidation) != null || 'メールアドレスの形式ではありません。',
      ],
      passwordRules: [
        v => !!v || 'パスワードが入力されていません。',
        v => v == null || (v.length >= constants.minPasswordLength && v.length <= constants.maxPasswordLength) || 'パスワードは6～32文字で設定して下さい。'
      ],
      breedRules: [
        v => !!v || '犬種は必須項目です。'
      ],
      locationRules: [
        v => !!v || '居住地は必須項目です。'
      ],
      weightErrorShow: false,
      ageErrorShow: false,
      breedErrorShow: false,
      prefectureErrorShow: false,
      agreeErrorShow: false,
      birthdayErrorShow: false,
      instagramId: null,
      twitterId: null,
      tiktokId: null,
      blogId: null,
      inputInstagram: null,
      inputTwitter: null,
      inputTiktok: null,
      inputBlog: null,
      year: null,
      month: null,
      day: null,
      isMix: false,
      location: null
    }
  },
  computed: {
    years () {
      const years = []
      for (let year = 2005; year <= new Date().getFullYear(); year++) {
        years.push(year)
      }
      return years
    },
    months () {
      const months = [...Array(12)].map((ele, i) => i + 1)
      return months
    },
    days () {
      let days = []
      if ((this.month === 2 && this.year % 4 === 0 && this.year % 100 !== 0) || (this.month === 2 && this.year % 400 === 0)) {
        days = [...Array(29)].map((ele, i) => i + 1)
      } else if (this.month === 2) {
        days = [...Array(28)].map((ele, i) => i + 1)
      } else if (this.month === 4 || this.month === 6 || this.month === 9 || this.month === 11) {
        days = [...Array(30)].map((ele, i) => i + 1)
      } else {
        days = [...Array(31)].map((ele, i) => i + 1)
      }
      return days
    },
  },
  methods: {
    clickFemale () {
      this.sex = 'female'
    },
    clickMale () {
      this.sex = 'male'
    },
    generateInputNum (item, index) {
      return `${item}_${index + 1}`
    },
    weightHandleInputFocus (index, event) {
      if (this.weightValues[index] && this.weightValues[index] !== '' && index < 1) {
        const [nextInput] = this.$refs[`weight_${index + 2}`]
        nextInput.focus()
      } else if (index > 0 && (!this.weightValues[index] || this.weightValues[index] === '') && event.key === 'Backspace') {
        const [previusInput] = this.$refs[`weight_${index}`]
        previusInput.focus()
      }
    },
    storeUserInfo () {
      if (this.$refs.signupForm.validate() && this.weightValues.length === 2 && this.checkbox != null && this.year !== null && this.month !== null & this.day !== null) {
        if (this.inputInstagram !== null && this.inputInstagram.match(/^https:\/\/(www.instagram.com\/)/)) {
            this.instagramId = this.inputInstagram.replace('https://www.instagram.com/', '')
        } else {
            this.instagramId = this.inputInstagram
        }
        if (this.inputTwitter !== null && this.inputTwitter.match(/^https:\/\/(twitter.com\/)/)) {
            this.twitterId = this.inputTwitter.replace('https://twitter.com/', '')
        } else {
            this.twitterId = this.inputTwitter
        }
        if (this.inputTiktok !== null && this.inputTiktok.match(/^https:\/\/(tiktok.com\/)/)) {
            this.tiktokId = this.inputTiktok.replace('https://tiktok.com/', '')
        } else {
            this.tiktokId = this.inputTiktok
        }
        this.blogId = this.inputBlog
        if (this.month < 10) {
          this.month = `0${this.month}`
        }
        if (this.day < 10) {
          this.day = `0${this.day}`
        }
        this.$emit('store-user-info', {
          sex: this.sex,
          name: this.name,
          email: this.email,
          password: this.password,
          weight: this.weightValues.join(''),
          birthday: `${this.year}-${this.month}-${this.day} 00:00:00`,
          breed1: this.itemBreed1,
          breed2: this.itemBreed2 ? this.itemBreed2 : null,
          location: this.location,
          instagramId: this.instagramId ? this.instagramId : null,
          twitterId: this.twitterId ? this.twitterId : null,
          tiktokId: this.tiktokId ? this.tiktokId : null,
          blogId: this.blogId ? this.blogId : null
        })
      }
      if (this.weightValues.length != 2) {
        this.weightErrorShow = true
      }
      if (this.breed === null) {
        this.breedErrorShow = true
      }
      if (this.checkbox != true) {
        this.agreeErrorShow = true
      }
      if (this.year === null || this.month === null || this.day === null) {
        this.birthdayErrorShow = true
      }
    },
    resetDay () {
      this.day = ''
    },
    clickMix () {
      this.isMix = true
    },
    closeMix () {
      this.isMix = false
    }
  }
}
</script>

<style scoped>
p {
  color: rgba(0, 0, 0, 0.6);
}

span {
  font-size: 20px;
  color: rgba(0, 0, 0, 0.6);
}

.fullyear .col {
  padding: 0;
}

.signup-form-wrap {
  padding-bottom: 30px;
}

.main-wrap {
  margin: 0 auto;
  max-width: 400px;
}

.form-content {
  margin-bottom: 20px;
}

.small-text {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1em;
  font-weight: bold;
  color: slategray;
}

.number {
  border: 2px solid #b9c9ce;
  border-radius: 5px;
  height: 50px;
  max-width: 50px;
  margin: 3px;
  font-size: 1.7em;
  text-align: center;
  font-family: 'Noto Sans JP', sans-serif;
  color: slategray;
}

.support-wrap {
  text-align: center;
}

.checkbox {
  text-align: center;
  margin-bottom: 10px;
}

.error-message {
  color: #DD2C00;
  font-size: 12px;
}

.text-label {
  color: white;
  background: slategray;
  font-size: 16px;
  display: inline-block;
  padding: 0 8px;
  border-radius: 2px;
  font-weight: bold;
}

.text-sns {
  display: inline-block;
  color: slategray;
}

.btn {
  color: rgba(0, 0, 0, 0.6);
}

@media screen and (min-width: 600px) {
  .number {
    height: 70px;
    max-width: 70px;
    margin: 10px;
    font-size: 2em;
  }
}
</style>
