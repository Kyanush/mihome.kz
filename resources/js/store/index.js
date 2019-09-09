import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth';
import errors from './modules/errors';

Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  modules: {
      auth,
      errors
  }
});

export default store;
