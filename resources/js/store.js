import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    cart: {
      items: []
    },
    currency: null
  },
  mutations: {
    addItem: (state, item) => {state.cart.items.push(item)},
    currency: (state, item) => {state.currency = item}
  },
  plugins: [createPersistedState()],
});

export default store
