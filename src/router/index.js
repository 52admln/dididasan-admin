import Vue from 'vue';
import Router from 'vue-router';
import login from '../components/pages/login/login';
import layout from '../components/common/layout/layout';
import index from '../components/pages/index/index';
import userAdd from '../components/pages/user/userAdd';
import userList from '../components/pages/user/userList';
import record from '../components/pages/record/record';
import changePwd from '../components/pages/admin/changePwd';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: '首页',
      component: layout,
      redirect: '/index',
      children: [
        {
          path: '/index', name: '仪表盘', component: index
        },
        {
          path: '/user/add', name: '新增用户', component: userAdd
        },
        {
          path: '/user/list', name: '用户管理', component: userList
        },
        {
          path: '/record/:type', name: '记录', component: record
        },
        {
          path: '/admin/password', name: '管理员', component: changePwd
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: login
    },
    {
      path: '*',
      name: '未找到页面',
      redirect: '/index'
    }
  ]
});

