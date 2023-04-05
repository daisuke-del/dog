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
                                年齢：{{ age }}歳
                            </p>
                            <p class="text-body-1 mx-2 my-1">
                                犬種：{{ breed }}
                            </p>
                        </div>
                    </div>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-divider class="mb-5" />
                    <v-form ref="weightForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            体重を変更
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field v-model="inputWeight" placeholder="体重" :rules="weightRules"
                                    autocomplete="off" outlined required dense />
                            </div>
                            <v-tooltip v-model="showWeightTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="weightLoading"
                                        v-bind="attrs" @click="submitWeight">
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                    <v-form ref="ageForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            年齢を変更
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field v-model="inputAge" placeholder="年齢" :rules="ageRules"
                                    autocomplete="off" outlined required dense />
                            </div>
                            <v-tooltip v-model="showAgeTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="ageLoading"
                                        v-bind="attrs" @click="submitAge">
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
                    <v-form ref="breedForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            犬種を変更
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field v-model="inputBreed" placeholder="犬種" :rules="breedRules"
                                    autocomplete="off" outlined required dense />
                            </div>
                            <v-tooltip v-model="showBreedTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="breedLoading"
                                        v-bind="attrs" @click="submitBreed">
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
        weight: {
            type: Number,
            default: ''
        },
        age: {
            type: Number,
            default: ''
        },
        breed: {
            type: String,
            default: ''
        },
        weightRules: {
            type: Array,
            default: () => []
        },
        ageRules: {
            type: Array,
            default: () => []
        },
        breedRules: {
            type: Array,
            default: () => []
        },
        showWeightTooltip: {
            type: Boolean,
            default: false
        },
        showAgeTooltip: {
            type: Boolean,
            default: false
        },
        showBreedTooltip: {
            type: Boolean,
            default: false
        },
        weightLoading: {
            type: Boolean,
            default: false
        },
        ageLoading: {
            type: Boolean,
            default: false
        },
        breedLoading: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            inputWeight: '',
            inputAge: '',
            inputSalary: '',
            breedRange: [
                '〜 199',
                '200 〜 399',
                '400 〜 599',
                '600 〜 799',
                '800 〜 999',
                '1000 〜 1999',
                '2000 〜 2999',
                '3000 〜',
            ],
            item: null
        }
    },
    methods: {
        submitWeight() {
            if (this.$refs.weightForm.validate()) {
                this.$emit('editWeight', this.inputWeight)
            }
        },
        submitAge() {
            if (this.$refs.ageForm.validate()) {
                this.$emit('editAge', this.inputAge)
            }
        },
        submitBreed() {
            if (this.$refs.breedForm.validate()) {
                this.$emit('editBreed', this.item)
            }
        }
    }
}
</script>

<style scoped>
@import 'assets/style/mypage/account.css';

.breed-box {
  font-family: 'Noto Sans JP', sans-serif;
  font-size: 1.2em;
  border: 2px solid #b9c9ce;
  border-radius: 5px;
  margin-bottom: 20px;
}
</style>
