<template>
  <div class="all">
    <v-row class="mt-3 mb-0" justify="center" align="center">
      <v-col cols="12" sm="8" xl="5" class="pa-0">
        <h1 class="my-0 mx-3 mx-sm-0">
          登録情報
        </h1>
        <div>
          <edit-email
            ref="editEmail"
            class="my-5 mx-2 mx-sm-0"
            :input-email.sync="email"
            :position="stepperPosition"
            :email-rules="emailRules"
            :email-loading="emailLoading"
            :password-rules="passwordRules"
            @clickUpdateEmail="clickUpdateEmail"
            @okClick="editEmail"
            @backClick="backClick"
          />
          <edit-name
            ref="editName"
            class="my-5 mx-2 mx-sm-0"
            :input-name.sync="name"
            :name-rules="nameRules"
            :loading="nameSendLoading"
            :show-tooltip="showNameTooltip"
            @editName="editName"
          />
          <edit-profile
            ref="editProfile"
            class="my-5 mx-2 mx-sm-0"
            :height="height"
            :weight="weight"
            :age="age"
            :salary="salary"
            :height-rules="heightRules"
            :weight-rules="weightRules"
            :age-rules="ageRules"
            :salary-rules="salaryRules"
            :height-loading="heightLoading"
            :weight-loading="weightLoading"
            :age-loading="ageLoading"
            :salary-loading="salaryLoading"
            :show-height-tooltip="showHeightTooltip"
            :show-weight-tooltip="showWeightTooltip"
            :show-age-tooltip="showAgeTooltip"
            :show-salary-tooltip="showSalaryTooltip"
            @editHeight="editHeight"
            @editWeight="editWeight"
            @editAge="editAge"
            @editSalary="editSalary"
          />
          <edit-sns
            ref="editSns"
            class="my-5 mx-2 mx-sm-0"
            :input-facebook.sync="facebookId"
            :input-instagram.sync="instagramId"
            :input-twitter.sync="twitterId"
            :facebook-rules="facebookRules"
            :instagram-rules="instagramRules"
            :twitter-rules="twitterRules"
            :facebook-loading="facebookLoading"
            :instagram-loading="instagramLoading"
            :twitter-loading="twitterLoading"
            :show-facebook-tooltip="showFacebookTooltip"
            :show-instagram-tooltip="showInstagramTooltip"
            :show-twitter-tooltip="showTwitterTooltip"
            @editFacebook="editFacebook"
            @editInstagram="editInstagram"
            @editTwitter="editTwitter"
          />
          <div class="leave-area mx-2 mx-sm-0">
            <a class="leave-button" @click="leaveClick">
              退会する
            </a>
          </div>
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import EditEmail from '@/components/Mypage/EditEmail'
import EditName from '@/components/Mypage/EditName'
import EditProfile from '@/components/Mypage/EditProfile'
import EditSns from '@/components/Mypage/EditSns'
import constants from '@/utils/constants'
import user from '~/plugins/modules/user'

export default {
  components: {
    EditEmail,
    EditName,
    EditProfile,
    EditSns
  },
  name: 'Mypageaccount',
  async asyncData({ app }) {
    let email = null
    let name = null
    let height = null
    let weight = null
    let age = null
    let salary = null
    let tmpSalary = null
    let dogImage = null
    let facebookId = null
    let instagramId = null
    let twitterId = null
    await user.getUserInfo().then((response) => {
      app.store.dispatch('authInfo/setAuthInfo', response)
      email = response['email']
      name = response['name']
      height = response['height']
      weight = response['weight']
      age = response['age']
      tmpSalary = response['salary']
      dogImage = response['dog_image']
      facebookId = response['facebook_id']
      instagramId = response['instagram_id']
      twitterId = response['twitter_id']
      if (tmpSalary < 200) {
        salary = '〜 199'
      } else if (tmpSalary < 400) {
        salary = '200 〜 399'
      } else if (tmpSalary < 600) {
        salary = '400 〜 599'
      } else if (tmpSalary < 800) {
        salary = '600 〜 799'
      } else if (tmpSalary < 1000) {
        salary = '800 〜 999'
      } else if (tmpSalary < 2000) {
        salary = '1000 〜 1999'
      } else if (tmpSalary < 3000) {
        salary = '2000 〜 2999'
      } else if (tmpSalary >= 3000) {
        salary = '3000 〜'
      }
    })
    return {
      email,
      name,
      height,
      weight,
      age,
      salary,
      dogImage,
      facebookId,
      instagramId,
      twitterId
    }
  },
  data() {
    return {
      stepperPosition: 1,
      loading: false,
      emailLoading: false,
      nameLoading: false,
      heightLoading: false,
      weightLoading: false,
      ageLoading: false,
      salaryLoading: false,
      facebookLoading: false,
      instagramLoading: false,
      twitterLoading: false,
      emailRules: [
        value => !!value || 'メールアドレスが入力されていません。',
        value => value.match(constants.mailValidation) != null || 'メールアドレスの形式ではありません。'
      ],
      passwordRules: [
        value => !!value || 'パスワードが入力されていません。',
        value => (value || '').length >= constants.minPasswordLength || '6文字以上で入力してください',
        value => (value || '').length <= constants.maxPasswordLength || '32文字以内で入力してください'
      ],
      nameRules: [
        value => !!value || 'ニックネームが入力されていません。',
        value => (value || '').length <= constants.maxNameLength || '10文字以内で入力してください',
      ],
      heightRules: [
        value => !!value || '身長が入力されていません。',
        value => (value || '').length <= constants.maxHeightLength || '3桁以上入力できません',
        value => value.match(constants.numberValidation) != null || '半角英数字で入力してください'
      ],
      weightRules: [
        value => !!value || '体重が入力されていません。',
        value => (value || '').length <= constants.maxWeightLength || '3桁以上入力できません',
        value => value.match(constants.numberValidation) != null || '半角英数字で入力してください'
      ],
      ageRules: [
        value => !!value || '年齢が入力されていません。',
        value => (value || '').length <= constants.maxAgeLength || '3桁以上入力できません',
        value => value.match(constants.numberValidation) != null || '半角英数字で入力してください'
      ],
      salaryRules: [
        value => !!value || '年収が選択されていません。',
      ],
      facebookRules: [
        value => !!value || 'facebookのIDが入力されていません。',
      ],
      instagramRules: [
        value => !!value || 'instagramのIDが入力されていません。',
      ],
      twitterRules: [
        value => !!value || 'twitterのIDが入力されていません。',
      ],
      newEmail: '',
      salary2: null,
      showPasswordTooltip: false,
      showNameTooltip: false,
      showHeightTooltip: false,
      showWeightTooltip: false,
      showAgeTooltip: false,
      showSalaryTooltip: false,
      showFacebookTooltip: false,
      showInstagramTooltip: false,
      showTwitterTooltip: false,
      passwordSendLoading: false,
      passwordMessage: '',
      showNameTooltip: false,
      nameSendLoading: false,
    }
  },
  methods: {
    backClick() {
      this.stepperPosition = 1
    },
    async clickUpdateEmail(mail) {
      await user.checkEmail(mail).then(() => {
        this.stepperPosition = 2
        this.newEmail = mail
      }).catch(() => {
      })
    },
    async editEmail(password) {
      await user.updateEmail(this.newEmail, password).then(() => {
        this.stepperPosition = 3
        this.$store.dispatch('authInfo/setEmail', this.newEmail)
        setTimeout(this.backClick, 3000)
      }).catch(() => {
        this.stepperPosition = 1
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
    },
    async editName(name) {
      this.nameSendLoading = true
      await user.updateName(name).then(() => {
        this.showNameTooltip = true
        this.$store.dispatch('authInfo/setName', name)
        setTimeout(() => {
          this.showNameTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.nameSendLoading = false
    },
    async editHeight(height) {
      this.heightLoading = true
      const heightInt = Number(height)
      await user.updateHeight(heightInt).then(() => {
        this.showHeightTooltip = true
        this.$store.dispatch('authInfo/setHeight', heightInt)
        this.height = heightInt
        setTimeout(() => {
          this.showHeightTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.heightLoading = false
    },
    async editWeight(weight) {
      this.weightLoading = true
      const weightInt = Number(weight)
      await user.updateWeight(weightInt).then(() => {
        this.showWeightTooltip = true
        this.$store.dispatch('authInfo/setWeight', weightInt)
        this.weight = weightInt
        setTimeout(() => {
          this.showWeightTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.weightLoading = false
    },
    async editAge(age) {
      this.ageLoading = true
      const ageInt = Number(age)
      await user.updateAge(ageInt).then(() => {
        this.showAgeTooltip = true
        this.$store.dispatch('authInfo/setAge', ageInt)
        this.age = ageInt
        setTimeout(() => {
          this.showAgeTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.ageLoading = false
    },
    async editSalary(salary) {
      if (salary === '〜 199') {
        this.salary2 = 150
      } else if (salary === '200 〜 399') {
        this.salary2 = 300
      } else if (salary === '400 〜 599') {
        this.salary2 = 500
      } else if (salary === '600 〜 799') {
        this.salary2 = 700
      } else if (salary === '800 〜 999') {
        this.salary2 = 900
      } else if (salary === '1000 〜 1999') {
        this.salary2 = 1100
      } else if (salary === '2000 〜 2999') {
        this.salary2 = 2000
      } else if (salary === '3000 〜') {
        this.salary2 = 3000
      }
      this.salaryLoading = true
      await user.updateSalary(this.salary2).then(() => {
        this.showSalaryTooltip = true
        this.$store.dispatch('authInfo/setSalary', this.salary2)
        this.salary = salary
        setTimeout(() => {
          this.showSalaryTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.salaryLoading = false
    },
    async editFacebook(facebook) {
      this.facebookLoading = true
      await user.updateFacebook(facebook).then(() => {
        this.showFacebookTooltip = true
        this.$store.dispatch('authInfo/setFacebookId', facebook)
        setTimeout(() => {
          this.showFacebookTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.facebookLoading = false
    },
    async editInstagram(instagram) {
      this.instagramLoading = true
      await user.updateInstagram(instagram).then(() => {
        this.showInstagramTooltip = true
        this.$store.dispatch('authInfo/setInstagramId', instagram)
        setTimeout(() => {
          this.showInstagramTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.instagramLoading = false
    },
    async editTwitter(twitter) {
      this.twitterLoading = true
      await user.updateTwitter(twitter).then(() => {
        this.showTwitterTooltip = true
        this.$store.dispatch('authInfo/setTwitterId', twitter)
        setTimeout(() => {
          this.showTwitterTooltip = false
        }, 3000)
      }).catch(() => {
        this.$store.dispatch('snackbar/setMessage', '更新に失敗しました。')
        this.$store.dispatch('snackbar/snackOn')
      })
      this.twitterLoading = false
    },
    leaveClick() {
      if (confirm('本当に退会して良いですか？')) {
        user.leave().then(() => {
          this.$auth.logout()
          this.$router.push('/')
        }).catch(() => {
          this.$store.dispatch('snackbar/setMessage', '退会できませんでした')
          this.$store.dispatch('snackbar/snackOn')
        })
      }
    }
  },
}
</script>

<style scoped>
h1 {
  font-family: 'Rampart One', cursive;
  color: dimgrey;
  margin: 20px;
  text-align: center;
}

.leave-area {
  text-align: right;
}

.leave-button {
  color: #000;
  text-decoration: underline;
  padding-right: 10px;
}
</style>