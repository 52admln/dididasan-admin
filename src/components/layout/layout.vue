<template>
  <div class="layout">
    <Row type="flex">
      <i-col span="5" class="layout-menu-left">
        <Menu active-name="1-1" theme="dark" width="auto" :open-names="['1']">
          <div class="layout-logo-left">滴滴打伞</div>
          <Submenu name="1">
            <template slot="title">
              <Icon type="ios-navigate"></Icon>
              用户

            </template>
            <router-link to="/user">
              <Menu-item name="1-1">管理用户</Menu-item>
            </router-link>
          </Submenu>
          <Submenu name="2">
            <template slot="title">
              <Icon type="ios-keypad"></Icon>
              记录

            </template>
            <router-link to="/record/need">
              <Menu-item name="2-1">求助记录</Menu-item>
            </router-link>
            <router-link to="/record/help">
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
    components: {
      'v-footer': footer,
      'v-header': header
    }
  };
</script>

<style lang="sass" rel="stylesheet/scss">
  @import "layout"
</style>
