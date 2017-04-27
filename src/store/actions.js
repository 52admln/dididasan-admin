/**
 * Created by Wyj on 3/30/17.
 */

export const login = ({commit}, data) => {
  console.log(data.username);
  console.log(data.token);
  commit({
    type: 'USER_LOGIN',
    username: data.username,
    token: data.token
  });
};

export const logout = ({commit}) => {
  commit('LOG_OUT');
};
