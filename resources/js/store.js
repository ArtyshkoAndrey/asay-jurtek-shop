import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    cart: {
      items: []
    }
  },
  mutations: {
    addItem: (state, item) => {state.cart.items.push(item)}
  },
  plugins: [createPersistedState()],
});

export default store
