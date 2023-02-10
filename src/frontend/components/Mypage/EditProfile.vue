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
                                身長：{{ height }}cm
                            </p>
                            <p class="text-body-1 mx-2 my-1">
                                体重：{{ weight }}kg
                            </p>
                            <p class="text-body-1 mx-2 my-1">
                                年齢：{{ age }}歳
                            </p>
                            <p class="text-body-1 mx-2 my-1">
                                年収：{{ salary }}万円
                            </p>
                        </div>
                    </div>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-divider class="mb-5" />
                    <v-form ref="heightForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            身長を変更
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field v-model="inputHeight" placeholder="身長" :rules="heightRules"
                                    autocomplete="off" outlined required dense />
                            </div>
                            <v-tooltip v-model="showHeightTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="heightLoading"
                                        v-bind="attrs" @click="submitHeight">
                                        変更
                                    </v-btn>
                                </template>
                                <span>変更しました</span>
                            </v-tooltip>
                        </div>
                    </v-form>
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
                    <v-form ref="salaryForm" @submit.prevent>
                        <p class="mb-2 text-subtitle-2 font-weight-bold">
                            年収を変更
                        </p>
                        <div class="text-field-and-btn">
                            <div class="text-field">
                                <v-text-field v-model="inputSalary" placeholder="年収" :rules="salaryRules"
                                    autocomplete="off" outlined required dense />
                            </div>
                            <v-tooltip v-model="showSalaryTooltip" top>
                                <template v-slot:activator="{ attrs }">
                                    <v-btn depressed color="primary" class="submit-button" :loading="salaryLoading"
                                        v-bind="attrs" @click="submitSalary">
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
        height: {
            type: Number,
            default: ''
        },
        weight: {
            type: Number,
            default: ''
        },
        age: {
            type: Number,
            default: ''
        },
        salary: {
            type: Number,
            default: ''
        },
        heightRules: {
            type: Array,
            default: () => []
        },
        weightRules: {
            type: Array,
            default: () => []
        },
        ageRules: {
            type: Array,
            default: () => []
        },
        salaryRules: {
            type: Array,
            default: () => []
        },
        showHeightTooltip: {
            type: Boolean,
            default: false
        },
        showWeightTooltip: {
            type: Boolean,
            default: false
        },
        showAgeTooltip: {
            type: Boolean,
            default: false
        },
        showSalaryTooltip: {
            type: Boolean,
            default: false
        },
        heightLoading: {
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
        salaryLoading: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            inputHeight: '',
            inputWeight: '',
            inputAge: '',
            inputSalary: '',
        }
    },
    methods: {
        submitHeight() {
            if (this.$refs.heightForm.validate()) {
                this.$emit('editHeight', this.inputHeight)
            }
        },
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
        submitSalary() {
            if (this.$refs.salaryForm.validate()) {
                this.$emit('editSalary', this.inputSalary)
            }
        }
    }
}
</script>

<style scoped>
@import 'assets/style/mypage/account.css';
</style>
