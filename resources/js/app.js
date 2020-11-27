import lodash from "lodash";
import store from "./store";
import Cookies from 'js-cookie';
import Swal from 'sweetalert2'
import kebabCase from 'lodash/kebabCase'

require('sweetalert');
require("slick-carousel");
window._ = lodash;
window.Vue = require('vue');
Vue.config.productionTip = false

const requireComponent = require.context(
  // Относительный путь до каталога компонентов
  './components',
  // Обрабатывать или нет подкаталоги
  true,
  // Регулярное выражение для определения файлов базовых компонентов
  /\w+\.(vue|js)$/
)

requireComponent.keys().forEach(fileName => {
  // Получение конфигурации компонента
  const componentConfig = requireComponent(fileName)

  // Получение имени компонента в PascalCase
  const componentName = kebabCase(
    // Удаление из начала `./` и расширения из имени файла
    fileName.replace(/^\.\/(.*)\.\w+$/, '$1')
  )
  /* eslint-disable no-console */
  // console.log('fileName',fileName,'=>',componentName);
  /* eslint-enable no-console */
  // Глобальная регистрация компонента
  Vue.component(
    componentName,
    // Поиск опций компонента в `.default`, который будет существовать,
    // если компонент экспортирован с помощью `export default`,
    // иначе будет использован корневой уровень модуля.
    componentConfig.default || componentConfig
  )
})

try {
  window.Popper = require('popper.js').default;
  window.$ = window.jQuery = require('jquery');
  require('bootstrap');
  require('select2');
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
    await window.axios.post('/auth')
      .then(response => {
        console.log(response);
        this.$store.commit('auth', response.data.auth)
      })
      .catch(error => {
        console.log(error)
      })
    if (!this.$store.getters.auth) {
      let items = this.$store.getters.items
      if (this.$store.state.currency === null || this.$store.state.currency.id !== Number(Cookies.get('cr'))) {
        await window.axios.post('/api/currency/get/' + Cookies.get('cr'))
          .then(response => {
            console.log(response);
            this.$store.commit('currency', response.data.currency)
            document.location.reload();
          })
          .catch(error => {
            console.log(error)
          })
      }
      if (items.length > 0) {
        await window.axios.post('/api/products/check', {
          ids: items.map(item => item.id)
        })
          .then(response => {
            if (items.length > response.data.items.length)
              Swal.fire({
                title: 'Упс...',
                text: 'Один из товаров в вашей корзине стал недоступен. Oн был автоматически удалён',
                confirmButtonColor: "#CF6B37",
              })
            this.$store.commit('clearCart')
            response.data.items.forEach(item => {
              this.addItemCart(item)
            })
          })
          .catch(error => {
            console.log(error)
          })
      }
    }
  },
  methods: {
    addItemCart (item) {
      this.$store.commit('addItem', item)
    }
  }
})
