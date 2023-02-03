export default Object.freeze({
  mailValidation: '^[a-zA-Z0-9.!#$%&\'*+\\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$',
  numberValidation: '[0-9]',
  minPasswordLength: 6,
  maxPasswordLength: 32,
  maxNameLength: 10,
  maxHeightLength: 3,
  maxWeightLength: 3,
  maxAgeLength: 3,
  maxSalaryLength: 4,
  errorMessage: '予期せぬエラーが発生しました。',
  numberValidation: '^[0-9]*$',
  notSavePreviousPage: [
    '/login',
    '/signup',
    '/update/password'
  ],
  errorCode: {
    emptyEmails: 101,
    no_user: 102,
    userInfoUpdateFailed: 103,
    underMaintenance: 200
  },
  errorCodeNotFound: 404
})