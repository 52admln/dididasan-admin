export default {
  USER_LOGIN(state, payload) {
    console.log(payload.user);
    localStorage.setItem('USER_NAME', payload.username);
    localStorage.setItem('JWT_TOKEN', payload.token);
  },
  LOG_OUT(state) {
    console.log('logout');
    localStorage.removeItem('JWT_TOKEN');
    localStorage.removeItem('USER_NAME');
  }
};
