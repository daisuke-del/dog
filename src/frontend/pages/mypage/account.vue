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
            :email="email"
            :position="stepperPosition"
            :email-rules="emailRules"
            :email-loading="emailLoading"
            :password-rules="passwordRules"
            @clickUpdateEmail="clickUpdateEmail"
            @onClick="editEmail"
            @backClick="backClick"
          />
          <edit-name
            ref="editName"
            class="my-5 mx-2 mx-sm-0"
            :name="name"
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
            :facebookId="facebookId"
            :instagramId="instagramId"
            :twitterId="twitterId"
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
import EditEmail from '@/components/MyPage/EditEmail'
import EditName from '@/components/MyPage/EditName'
import EditProfile from '@/components/MyPage/EditProfile'
// import EditImage from '@/components/MyPage/EditImage'
import EditSns from '@/components/MyPage/EditSns'
import constants from '@/utils/constants'
import user from '~/plugins/modules/user'

export default {
  components: {
    EditEmail,
    EditName,
    EditProfile,
    EditSns,
    // EditImage
  },
  name: 'Mypageaccount',
  async asyncData({ app }) {
    let email = null
    let name = null
    let height = null
    let weight = null
    let age = null
    let salary = null
    let faceImage = null
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
      salary = response['salary']
      faceImage = response['face_image']
      facebookId = response['facebook_id']
      instagramId = response['instagram_id']
      twitterId = response['twitter_id']
    })
    return {
      email,
      name,
      height,
      weight,
      age,
      salary,
      faceImage,
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
        value => (value || '').length >= constants.minPasswordLength || '8文字以上で入力してください',
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
      await user.checkEmail(mail).then((response) => {
        console.log(response)
        this.stepperPosition = 2
        this.newEmail = mail
      }).catch(() => {
      })
    },
    async editEmail(mail) {
      await user.checkEmail(mail).then((response) => {
        this.stepperPosition = 2
        this.newEmail = mail
      }).catch(() => {
      })
    },
    async editName(name) {
      this.nameSendLoading = true
      await user.updateName(name).then((response) => {
        this.name = response.name
        this.showNameTooltip = true
        setTimeout(() => {
          this.showNameTooltip = false
        }, 3000)
        this.$refs.editName.$refs.form.reset()
      }).catch(() => {
      })
      this.nameSendLoading = false
    },
    async editHeight(height) {
      this.heightLoading = true
      await user.updateHeight(height).then((response) => {
        this.height = response.height
        this.showHeightTooltip = true
        setTimeout(() => {
          this.showHeightTooltip = false
        }, 3000)
        this.$refs.editProfile.$refs.heightForm.reset()
      }).catch(() => {
      })
      this.heightLoading = false
    },
    async editWeight(weight) {
      this.weightLoading = true
      await user.updateWeight(weight).then((response) => {
        this.weight = response.weight
        this.showWeightTooltip = true
        setTimeout(() => {
          this.showWeightTooltip = false
        }, 3000)
        his.$refs.editProfile.$refs.weightForm.reset()
      }).catch(() => {
      })
      this.weightLoading = false
    },
    async editAge(age) {
      this.ageLoading = true
      await user.updateAge(age).then((response) => {
        this.age = response.age
        this.showAgeTooltip = true
        setTimeout(() => {
          this.showAgeTooltip = false
        }, 3000)
        his.$refs.editProfile.$refs.ageForm.reset()
      }).catch(() => {
      })
      this.ageLoading = false
    },
    async editSalary(salary) {
      this.salaryLoading = true
      await user.updateSalary(salary).then((response) => {
        this.salary = response.salary
        this.showSalaryTooltip = true
        setTimeout(() => {
          this.showSalaryTooltip = false
        }, 3000)
        his.$refs.editProfile.$refs.salaryForm.reset()
      }).catch(() => {
      })
      this.salaryLoading = false
    },
    async editFacebook(facebook) {
      this.facebookLoading = true
      await user.updateFacebook(facebook).then((response) => {
        this.facebookId = response.facebookId
        this.showFacebookTooltip = true
        setTimeout(() => {
          this.showFacebookTooltip = false
        }, 3000)
        this.$refs.editSns.$refs.facebookForm.reset()
      }).catch(() => {
      })
      this.facebookLoading = false
    },
    async editInstagram(instagram) {
      this.instagramLoading = true
      await user.updateInstagram(instagram).then((response) => {
        this.instagramId = response.instagramId
        this.showInstagramTooltip = true
        setTimeout(() => {
          this.showInstagramTooltip = false
        }, 3000)
        this.$refs.editSns.$refs.instagramForm.reset()
      }).catch(() => {
      })
      this.instagramLoading = false
    },
    async editTwitter(twitter) {
      this.twitterLoading = true
      await user.updateTwitter(twitter).then((response) => {
        this.twitterId = response.twitterId
        this.showTwitterTooltip = true
        setTimeout(() => {
          this.showTwitterTooltip = false
        }, 3000)
        this.$refs.editSns.$refs.twitterForm.reset()
      }).catch(() => {
      })
      this.twitterLoading = false
    },
    leaveClick() {
      window.location.href = 'https://www.mgstage.com/joinleave/leave.php?agef=1'
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
}
</style>