<template>
    <v-card outlined light>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-header expand-icon="mdi-pencil" disable-icon-rotate>
                    <div class="info-display-area">
                        <div>
                            <p class="text-h6 font-weight-bold ma-0">
                                プロフィール
                            </p>
                            <p class="text-body-1 mx-2 my-1">
                                体重：{{ weight }}kg
                            </p>
                            <p class="text-body-1 mx-2 my-1">
                                生年月日：{{ dogBirthday }}
                            </p>
                            <p v-if="!breed2" class="text-body-1 mx-2 my-1">
                                犬種：{{ breed1 }}
                            </p>
                            <p v-else class="text-body-1 mx-2 my-1">犬種：{{ breed1 }} / {{ breed2 }}</p>
                        </div>
                    </div>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-divider class="mb-5" />
                    <v-form ref="breedForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            犬種を変更
                        </p>
                        <div class="text-field-and-btn">
                            <label class="form-content">
                                <v-select
                                    v-model="itemBreed1"
                                    :items="breedRange"
                                    label="犬種を選択"
                                    hide-details
                                    outlined
                                    class="mb-2 breed"
                                />
                                <v-select
                                    v-if="isMix"
                                    v-model="itemBreed2"
                                    :items="breedRange"
                                    label="犬種を選択"
                                    hide-details
                                    outlined
                                    class="mb-2 breed"
                                />
                            </label>
                            <v-tooltip v-model="showBreedTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn
                                        depressed
                                        color="primary"
                                        class="submit-button"
                                        :loading="breedLoading"
                                        v-bind="attrs"
                                        @click="submitBreed"
                                    >
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
                            </v-tooltip>
                        </div>
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
                    </v-form>
                    <v-form ref="weightForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            体重を変更
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
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
                                    oninput="value = value.replace(/[^0-9]+/i,'');"
                                    @keyup="weightHandleInputFocus(index, $event)"
                                >
                                <span>kg</span>
                            </div>
                            <v-tooltip v-model="showWeightTooltip" top>
                                <template
                                    v-slot:activator="{ attrs }"
                                >
                                    <v-btn
                                        depressed
                                        color="primary"
                                        class="submit-button"
                                        :loading="weightLoading"
                                        v-bind="attrs"
                                        @click="submitWeight"
                                    >
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                    <v-form ref="birthdayForm" class="birthday-form" @submit.prevent>
                        <p class="mb-2 mt-5 text-subtitle-2 font-weight-bold">
                            生年月日を変更
                        </p>
                        <div class="text-field-and-btn">
                            <v-row class="birthday mr-10">
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
                                    hide-details
                                    label="月"
                                    outline
                                    @change="resetDay"
                                    />
                                </v-col>
                                <v-col cols="3">
                                    <v-select
                                    v-model="day"
                                    :items="days"
                                    label="日"
                                    hide-details
                                    outline
                                    />
                                </v-col>
                            </v-row>
                            <v-tooltip
                                v-model="showBirthdayTooltip"
                                top
                            >
                                <template v-slot:activator="{ attrs }">
                                    <v-btn
                                        depressed
                                        color="primary"
                                        class="submit-button mt-5"
                                        :loading="birthdayLoading"
                                        v-bind="attrs"
                                        @click="submitBirthday"
                                    >
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
    </v-card>
</template>

<script>
export default {
    props: {
        breed1: {
            type: String,
            default: ''
        },
        breed2: {
            type: String,
            default: ''
        },
        weight: {
            type: Number,
            default: ''
        },
        birthday: {
            type: String,
            default: ''
        },
        location: {
            type: String,
            default: ''
        },
        breedRules: {
            type: Array,
            default: () => []
        },
        weightRules: {
            type: Array,
            default: () => []
        },
        birthdayRules: {
            type: Array,
            default: () => []
        },
        locationRules: {
            type: Array,
            default: () => []
        },
        showBreedTooltip: {
            type: Boolean,
            default: false
        },
        showWeightTooltip: {
            type: Boolean,
            default: false
        },
        showBirthdayTooltip: {
            type: Boolean,
            default: false
        },
        breedLoading: {
            type: Boolean,
            default: false
        },
        weightLoading: {
            type: Boolean,
            default: false
        },
        birthdayLoading: {
            type: Boolean,
            default: false
        },
        locationdLoading: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            inputWeight: '',
            item: null,
            itemBreed1: null,
            itemBreed2: null,
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
            isMix: false,
            year: null,
            month: null,
            day: null,
            weightValues: [0],
            itemBreed1: null,
            itemBreed2: null,
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
        dogBirthday () {
            const birthDate = new Date(this.birthday);
            const year = birthDate.getFullYear();
            const month = ("0" + (birthDate.getMonth() + 1)).slice(-2);
            const day = ("0" + birthDate.getDate()).slice(-2);
            return `${year}年${month}月${day}日`;
        }
    },
    methods: {
        submitWeight () {
            if (this.$refs.weightForm.validate()) {
                this.$emit('editWeight', this.weightValues.join(''))
            }
        },
        submitBirthday () {
            if (this.$refs.birthdayForm.validate()) {
                if (this.month < 10 && this.month !== null) {
                    this.month = `0${this.month}`
                }
                if (this.month < 10 && this.day !== null) {
                    this.day = `0${this.day}`
                }
                this.$emit('editBirthday', this.year, this.month, this.day)
            }
        },
        submitBreed () {
            if (this.$refs.breedForm.validate()) {
                this.$emit('editBreed', this.itemBreed1, this.itemBreed2)
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
        }
    }
}
</script>

<style scoped>
@import 'assets/style/mypage/account.css';
.col {
    padding: 6px !important;
}

.breed {
    max-width: 95%;
}

.birthday {
    width: 90%;
    max-width: 350px;
}

.number {
    border: 1px solid rgba(0, 0, 0, 0.87);
    border-radius: 5px;
    height: 50px;
    max-width: 50px;
    margin: 3px;
    font-size: 1.7em;
    text-align: center;
    font-family: 'Noto Sans JP', sans-serif;
}
</style>
