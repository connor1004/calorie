import Vue from "vue";
import Vuex from "vuex";

import auth from "./modules/auth";

Vue.use(Vuex);
// Need to use the spread operator, otherwise nested objects/arrays won't be reset on calling resetStore
let initState = {
  auth: { ...auth.state }
};

// divide the store into separate modules
// https://vuex.vuejs.org/guide/modules.html
export default new Vuex.Store({
  modules: {
    auth
  },
  mutations: {
    // We need to reset the store, otherwise upon logging in, the old data will still be in memory
    // https://github.com/vuejs/vuex/issues/1118
    // If you simply set the state as empty, you will lose reactivity so we need to loop over all the keys
    resetState(state) {
      Object.keys(state).forEach(key => {
        Object.assign(state[key], initState[key]);
      });
    }
  },
  actions: {
    resetStore({ commit }) {
      commit("resetState");
    }
  }
});
