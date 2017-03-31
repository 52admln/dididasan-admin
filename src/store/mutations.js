export default {
  USER_LOGIN(state, payload) {
    console.log(payload.user);
    state.user_login = true;
    state.user_info = payload.user;
    window.location.href = '/#/index';
  },
  LOG_OUT(state) {
    console.log('logout');
    state.user_login = false;
    state.user_info = '';
    window.location.href = '/#/login';
  }
};
