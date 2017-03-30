/**
 * Created by Wyj on 3/30/17.
 */

export const getUser = (state) => {
  return {
    user: state.loginUser,
    status: state.loginStatus
  };
};
