/**
 * Created by Wyj on 3/30/17.
 */

export const getUser = (state) => {
  return localStorage.getItem('USER_NAME');
};

export const getToken = (state) => {
  return localStorage.getItem('JWT_TOKEN');
};
