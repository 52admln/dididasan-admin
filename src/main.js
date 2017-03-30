// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import iView from 'iview';
import 'iview/dist/styles/iview.css';    // 使用 CSS
import axios from 'axios';
import App from './App';
import router from './router';
import store from './store';

Vue.use(iView);
Vue.prototype.$http = axios;

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  ...App,
  store
}).$mount('#app');

// router.push('/index');
