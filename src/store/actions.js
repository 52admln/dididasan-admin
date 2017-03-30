/**
 * Created by Wyj on 3/30/17.
 */

export const loginSuccess = ({commit}, username) => {
  console.log(username);
  // commit('LOGIN_SUCCESS', {
  //   user: username
  // });
  commit({
    type: 'LOGIN_SUCCESS',
    user: username
  });
};

export const logout = ({commit}) => {
  commit('LOG_OUT');
};
