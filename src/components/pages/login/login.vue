<template>
  <div class="login-wrapper">
    <div class="login-form">
      <h3 class="title">管理员登录</h3>
      <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top" class="form-area">
        <Form-item label="用户名" prop="username">
          <Input v-model="formValidate.username"></Input>
        </Form-item>
        <Form-item label="密码" prop="password">
          <Input type="password" v-model="formValidate.password"></Input>
        </Form-item>
        <Form-item>
          <Button type="primary" @click="handleSubmit('formValidate')" long>立即登录</Button>
        </Form-item>
      </Form>
    </div>
  </div>
</template>

<script>
  const OK = 0; // 返回数据正常

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
//            const params = new URLSearchParams();
//            params.append('username', this.formValidate.username);
//            params.append('password', this.formValidate.password);
            this.$http.post('/api/admin/login', {
              username: this.formValidate.username,
              password: this.formValidate.password
            })
              .then((response) => {
                console.log(response.data);
                if (response.data.err === OK && response.data.data > 0) {
                  this.$Message.success('登录成功!');
                  // dispatch action，从action commit 到mutation更新登录状态
                  this.$store.dispatch('login', this.formValidate.username);
                } else {
                  this.$Message.error('帐号或密码有误!');
                }
              })
              .catch((error) => {
                console.log(error);
                this.$Message.error('网络请求有误，请稍后重试!');
              });
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
