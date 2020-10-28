import lodash from "lodash";
import store from "./store";

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
  mounted () {
    console.log(this.$store.state.cart.items.find(x => x.id === 2))
  },
  methods: {
    addItemCart (item) {
      this.$store.commit('addItem', item)
    }
  }
})
