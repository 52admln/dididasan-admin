<template>
  <div class="layout">
    <Row type="flex">
      <i-col span="5" class="layout-menu-left">
        <Menu active-name="0-1" theme="dark" width="auto" :accordion="true" :open-names="['0']">
          <div class="layout-logo-left">滴滴打伞</div>
          <Submenu name="0">
            <template slot="title">
              <Icon type="ios-navigate"></Icon>
              仪表盘
            </template>
            <router-link to="/index">
              <Menu-item name="0-1">
                首页
              </Menu-item>
            </router-link>
          </Submenu>
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
            <router-link to="/record">
              <Menu-item name="2-1">管理记录</Menu-item>
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
              <router-view></router-view>
          </div>
        </div>
        <v-footer></v-footer>
      </i-col>
    </Row>
    <Back-top></Back-top>
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
//      this.$nextTick(() => {
//        // 未登录状态跳转至登录页
//        console.log(this.$store.getters.getUser.status);
//        window.location.href = '/#/index';
//        if (this.$store.getters.getUser.status === false) {
//          window.location.href = '/#/login';
//        }
//      });
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
