import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
// import js from '../js/map'

import '~/plugins'
import '~/components'
import jQuery from 'jquery'
import ToggleButton from 'vue-js-toggle-button'

Vue.config.productionTip = false
Vue.use(ToggleButton)
/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  // js,
  ...App
})
