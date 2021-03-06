import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    cart: {
      items: []
    },
    currency: null,
    auth: false
  },
  mutations: {
    addItem: (state, item) => {state.cart.items.push(item)},
    removeItem: (state, id) => { state.cart.items = state.cart.items.filter( e => e.id !== id ) },
    clearCart: (state) => {state.cart.items = []},
    currency: (state, item) => {state.currency = item},
    auth: (state, auth) => {state.auth = auth},
  },
  getters: {
    items: state => {
      return state.cart.items;
    },
    priceAmount: state => {
      return state.cart.items.reduce((sum, item) => {
        return sum + (item.on_sale ? Number(item.price_sale) : Number(item.price))
      }, 0) * state.currency.ratio;
    },
    auth: state => {
      return state.auth;
    }
  },
  plugins: [createPersistedState()],
});

export default store
