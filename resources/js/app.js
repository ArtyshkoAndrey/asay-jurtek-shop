import lodash from "lodash";
import store from "./store";
import Cookies from 'js-cookie';
// import axios from 'axios';

require('sweetalert');
window._ = lodash;
window.Vue = require('vue');
Vue.config.productionTip = false

try {
  window.Popper = require('popper.js').default;
  window.$ = window.jQuery = require('jquery');
  require('bootstrap');
  // require('flot');
  window.axios = require('axios');
  window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
  let token = document.head.querySelector('meta[name="csrf-token"]');

  if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
  } else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
  }
} catch (e) {}

Vue.prototype.$cost = function (number) {
  return new Intl.NumberFormat('ru-RU').format((number).toFixed(0))
}
Vue.config.devtools = true;
Vue.config.performance = true;

const app = new Vue({
  el: '#app',
  store: store,
  data() {
    return {
    }
  },
  async mounted  () {
    if (this.$store.state.currency === null) {
      await window.axios.post('/api/currency/get/' + Cookies.get('cr'))
        .then(response => {
          console.log(response);
          this.$store.commit('currency', response.data.currency)
        })
        .cath(error => {
          console.log(error)
        })
    }
  },
  methods: {
    addItemCart (item) {
      this.$store.commit('addItem', item)
    }
  }
})
