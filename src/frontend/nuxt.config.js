import colors from 'vuetify/es5/util/colors'

const environment = process.env.NODE_ENV
const envSet = require(`./env.${environment}.js`)

export default {
  env: envSet,
  ssr: true,

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: '%s - dogisland',
    title: 'ドッグアイランド',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'dogisland' },
      { name: 'format-detection', content: 'telephone=no' },
      { name: 'twitter:image', content: 'https://www.dogiland.jp/storage/image/logo-dog-small.png'},
      { name: 'twitter:title', content: 'ドッグアイランド'},
      { name: 'twitter:description', content: '【完全無料】愛犬を登録してみよう！ランクインして、目指せインフルエンサー犬！'}
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: "preconnect", href: "https://fonts.googleapis.com"},
      { rel: "preconnect", href: "https://fonts.gstatic.com" },
      { rel: "stylesheet", href: "https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;400;500;700&display=swap" },
      { rel: "stylesheet", href: "https://fonts.googleapis.com/css?family=Plus Jakarta Sans" },
      { rel: "android-icon", sizes: "152x152", href: "https://www.dogiland.jp/storage/image/logo-dog-small.png"},
      {
        rel: 'stylesheet',
        href: 'https://use.fontawesome.com/releases/v5.15.3/css/all.css',
        integrity: 'xxxx', // Font Awesomeのリンクに記載されているインテグリティハッシュ
        crossorigin: 'anonymous'
      }
    ],
    script: [
      { src: "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?" },
      { client: "ca-pub-4702212307993532" },
      { async: true}
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    '~/plugins/axios'
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    '@nuxtjs/eslint-module',
    // https://go.nuxtjs.dev/stylelint
    '@nuxtjs/stylelint-module',
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    // https://go.nuxtjs.dev/pwa
    '@nuxtjs/pwa',
    // https://go.nuxtjs.dev/content
    '@nuxt/content',
    'nuxt-svg-loader'
  ],

  proxy: {
    '/api/': {
      target: envSet.apiBaseUrl
    },
    '/user/': {
      target: envSet.apiBaseUrl
    },
    '/favorite/': {
      target: envSet.apiBaseUrl
    },
    '/forget/': {
      target: envSet.apiBaseUrl
    },
    '/update/': {
      target: envSet.apiBaseUrl
    },
    '/admin/': {
      target: envSet.apiBaseUrl
    },
    '/sanctum/': {
      target: envSet.apiBaseUrl
    }
  },

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    proxy: true,
    credentials: true
  },
  auth: {
    plugins: ['~/plugins/auth'],
    redirect: {
      login: '/login',
      logout: '/',
    },
    strategies: {
      login: {
        scheme: 'local',
        endpoints: {
          login: {
            url: '/user/login',
            method: 'post',
            propertyName: false
          },
          logout: {
            url: '/user/logout',
            method: 'post',
            propertyName: false
          },
          user: false
        }
      },
      signUp: {
        scheme: 'local',
        endpoints: {
          login: {
            url: '/user/signup',
            method: 'post',
            propertyName: false
          },
          logout: {
            url: '/user/logout',
            method: 'post',
            propertyName: false
          },
          user: false
        }
      },
      admin: {
        scheme: 'local',
        endpoints: {
          login: {
            url: '/admin/login',
            method: 'post',
            propertyName: false
          },
          logout: {
            url: '/admin/logout',
            method: 'post',
            propertyName: false
          },
          user: false
        }
      }
    }
  },
  router: {
    middleware: ['auth', 'update_user_status']
  },

  // PWA module configuration: https://go.nuxtjs.dev/pwa
  pwa: {
    manifest: {
      lang: 'en',
    },
  },

  // Content module configuration: https://go.nuxtjs.dev/config-content
  content: {},

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    treeShake: true,
    customVariables: ['~/assets/variables.scss'],
    theme: {
      dark: false,
      themes: {
        dark: {
          primary: '#84D1E2',
          secondary: '#F0E8E0',
          accent: '#7D7D7D',
          info: '#384878',
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3,
          test: '#505050'
        },
        light: {
          primary: '#84D1E2',
          secondary: '#F0E8E0',
          accent: '#7D7D7D',
          info: '#384878',
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3,
          test: '#505050'
        },
      },
    },
  },

  generate: {
    routes: async () => {
      let breeds = []
      await axios.get('/api/breed/route').then((response) => {
        breeds = response
      })
      return breeds.map(breed => `/breed/detail/${breed}`)
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {},
}
