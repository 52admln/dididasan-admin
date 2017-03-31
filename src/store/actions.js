/**
 * Created by Wyj on 3/30/17.
 */

export const login = ({commit}, username) => {
  console.log(username);
  commit({
    type: 'USER_LOGIN',
    user: username
  });
};

export const logout = ({commit}) => {
  commit('LOG_OUT');
};
