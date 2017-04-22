<template>
  <div class="layout">
    <Row type="flex">
      <i-col span="5" class="layout-menu-left">
        <Menu active-name="0" theme="dark" width="auto">
          <div class="layout-logo-left">Logo Name</div>
          <router-link to="/index">
            <Menu-item name="0">
              <Icon type="ios-navigate"></Icon>
              仪表盘
            </Menu-item>
          </router-link>
          <Submenu name="1">
            <template slot="title">
              <Icon type="ios-person"></Icon>
              用户
            </template>
            <router-link to="/user/add">
              <Menu-item name="1-1">新增用户</Menu-item>
            </router-link>
            <router-link to="/user/list">
              <Menu-item name="1-2">管理用户</Menu-item>
            </router-link>
          </Submenu>
          <Submenu name="2">
            <template slot="title">
              <Icon type="ios-keypad"></Icon>
              记录
            </template>
            <router-link to="/record/needer">
              <Menu-item name="2-1">求助记录</Menu-item>
            </router-link>
            <router-link to="/record/helper">
              <Menu-item name="2-2">帮助记录</Menu-item>
            </router-link>
          </Submenu>
          <Submenu name="3">
            <template slot="title">
              <Icon type="ios-analytics"></Icon>
              管理员
            </template>
            <router-link to="/admin/password">
              <Menu-item name="3-1">修改密码</Menu-item>
            </router-link>
          </Submenu>
        </Menu>
      </i-col>
      <i-col span="19" class="layout-content-right">
        <v-header></v-header>
        <div class="layout-breadcrumb">
          <Breadcrumb>
            <Breadcrumb-item href="/#/index">首页</Breadcrumb-item>
            <Breadcrumb-item>{{ name }}</Breadcrumb-item>
          </Breadcrumb>
        </div>
        <div class="layout-content">
          <div class="layout-content-main">
            <transition name="fade">
              <router-view></router-view>
            </transition>
          </div>
        </div>
        <v-footer></v-footer>
      </i-col>
    </Row>
  </div>
</template>
<script type="text/ecmascript-6">
  import footer from '../footer/footer';
  import header from '../header/header';

  export default {
    computed: {
      name() {
        return this.$route.name;
      }
    },
    created() {
      this.$nextTick(() => {
        // 未登录状态跳转至登录页
        console.log(this.$store.getters.getUser.status);
        window.location.href = '/#/index';
        if (this.$store.getters.getUser.status === false) {
          window.location.href = '/#/login';
        }
      });
    },
    components: {
      'v-footer': footer,
      'v-header': header
    }
  };
</script>

<style lang="sass" rel="stylesheet/scss">
  @import "layout"
</style>
