import Vue from 'vue';
import Vuex from 'vuex';
import * as actions from './actions';
import * as getters from './getters';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

const state = {
  loginStatus: '0',
  loginUser: ''
};

const mutations = {
  LOGIN_SUCCESS(state, payload) {
    console.log(payload.user);
    state.loginStatus = '1';
    state.loginUser = payload.user;
    window.location.href = '/#/index';
  },
  LOG_OUT(state) {
    console.log('logout');
    state.loginStatus = '0';
    state.loginUser = '';
    window.location.href = '/#/login';
  }
};

export default new Vuex.Store({
  state,
  actions,
  mutations,
  getters,
  strict: debug
});
