/**
 * Created by Wyj on 3/30/17.
 */

export const getUser = (state) => {
  return {
    user: state.user_info,
    status: state.user_login
  };
};
