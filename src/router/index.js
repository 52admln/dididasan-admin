import Vue from 'vue';
import Router from 'vue-router';
import login from '../components/login/login';
import layout from '../components/layout/layout';
import index from '../components/index/index';
import user from '../components/user/user';
import record from '../components/record/record';
import admin from '../components/admin/admin';
import adminPwd from '../components/admin/adminPwd';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: '首页',
      component: layout,
      children: [
        {
          path: 'index',
          name: '仪表盘',
          component: index
        },
        {
          path: 'user',
          name: '用户',
          component: user
        },
        {
          path: 'record/:type',
          name: '记录',
          component: record
        },
        {
          path: 'admin',
          name: '管理员',
          component: admin,
          children: [
            {
              path: 'password', name: '修改密码', component: adminPwd
            }
          ]
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: login
    }

  ]
});
