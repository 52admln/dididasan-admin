<template>
  <div class="login-wrapper">
    <div class="login-form">
      <h3 class="title">管理员登录</h3>
      <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top" class="form-area">
        <Form-item label="用户名" prop="username">
          <Input v-model="formValidate.username"></Input>
        </Form-item>
        <Form-item label="密码" prop="password">
          <Input v-model="formValidate.password"></Input>
        </Form-item>
        <Form-item>
          <Button type="primary" @click="handleSubmit('formValidate')" long>立即登录</Button>
        </Form-item>
      </Form>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        formValidate: {
          username: '',
          password: ''
        },
        ruleValidate: {
          username: [
            {
              required: true,
              message: '请输入用户名',
              trigger: 'blur'
            }
          ],
          password: [
            {
              required: true,
              message: '请输入密码',
              trigger: 'blur'
            }
          ]
        }
      };
    },
    methods: {
      handleSubmit(name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
            this.$Message.success('提交成功!');
            const params = new URLSearchParams();
            params.append('username', this.formValidate.username);
            params.append('password', this.formValidate.password);
            this.$http.post('/api/login', params)
              .then((response) => {
                console.log(response.data);
              })
              .catch((error) => {
                console.log(error);
              });
//            this.$router.push('/index');
          } else {
            this.$Message.error('表单填写有误!');
          }
        });
      }
    }
  };
</script>

<style lang="sass" rel="stylesheet/scss">
  @import "login"
</style>
