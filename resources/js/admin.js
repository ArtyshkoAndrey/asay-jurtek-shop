import lodash from "lodash";

require('sweetalert');
window._ = lodash;
window.Vue = require('vue');
Vue.config.productionTip = false

try {
  window.Popper = require('popper.js').default;
  window.$ = window.jQuery = require('jquery');
  require('bootstrap');
  require('select2');
  require('icheck');
  require('flot');

  window.axios = require('axios');
  window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
  let token = document.head.querySelector('meta[name="csrf-token"]');

  if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
  } else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
  }
} catch (e) {}

require('admin-lte');
