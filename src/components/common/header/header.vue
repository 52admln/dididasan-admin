<template>
  <div class="layout-header">
    <Dropdown class="user">
              <span class="info">
              <img src="http://work.fengdb.com/static/img/img.2aab7b4.jpg" alt="" class="avatar">
              <span class="nickname">{{ userName }}</span>
            </span>
      <Dropdown-menu slot="list">
        <router-link to="/admin/password">
          <Dropdown-item>修改密码</Dropdown-item>
        </router-link>
        <Dropdown-item divided><span @click="logout">注销</span></Dropdown-item>
      </Dropdown-menu>
    </Dropdown>
  </div>
</template>

<script type="text/ecmascript-6">
  export default {
    computed: {
      userName() {
        return this.$store.getters.getUser;
      }
    },
    methods: {
      logout() {
        this.$store.dispatch('logout');
        this.$Message.warning('已登出!');
        this.$router.push('/login');
      }
    }
  };
</script>

<style lang="sass" rel="stylesheet/scss">

</style>
