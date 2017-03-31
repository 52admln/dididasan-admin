import Vue from 'vue';
import Vuex from 'vuex';
import * as actions from './actions';
import * as getters from './getters';
import mutations from './mutations';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

const state = {
  user_login: false,
  user_info: ''
};

export default new Vuex.Store({
  state,
  actions,
  mutations,
  getters,
  strict: debug
});
