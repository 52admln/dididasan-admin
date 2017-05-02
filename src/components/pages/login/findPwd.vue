<template>
  <div class="login-wrapper">
    <div class="login-form">
      <h3 class="title">找回密码</h3>
      <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top" class="form-area">
        <Form-item label="邮箱" prop="email">
          <Input v-model="formValidate.email" placeholder="请输入绑定的邮箱"></Input>
        </Form-item>
        <Form-item label="新密码" prop="passwd">
          <Input type="password" v-model="formValidate.passwd"></Input>
        </Form-item>
        <Form-item label="重复密码" prop="passwdCheck">
          <Input type="password" v-model="formValidate.passwdCheck"></Input>
        </Form-item>
        <Form-item>
          <Button type="primary" html-type="submit" @click="handleSubmit('formValidate')" long>重置密码</Button>
        </Form-item>
      </Form>
    </div>
  </div>
</template>

<script>
  const OK = 0; // 返回数据正常

  export default {
    data() {
      const validatePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码'));
        } else {
          if (this.formValidate.passwdCheck !== '') {
            // 对第二个密码框单独验证
            this.$refs.formValidate.validateField('passwdCheck');
          }
          callback();
        }
      };
      const validatePassCheck = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'));
        } else if (value !== this.formValidate.passwd) {
          callback(new Error('两次输入密码不一致!'));
        } else {
          callback();
        }
      };
      return {
        formValidate: {
          email: '',
          passwd: '',
          passwdCheck: ''
        },
        ruleValidate: {
          email: [
            {
              required: true,
              message: '请输入邮箱',
              trigger: 'blur',
              type: 'email'
            }
          ],
          passwd: [
            {validator: validatePass, trigger: 'blur'}
          ],
          passwdCheck: [
            {validator: validatePassCheck, trigger: 'blur'}
          ]
        }
      };
    },
    methods: {
      handleSubmit(name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
            const params = new URLSearchParams();
            params.append('email', this.formValidate.email);
            params.append('password', this.formValidate.passwd);
            params.append('confirm_password', this.formValidate.passwdCheck);
            params.append('token', this.$route.query.token);
            this._validateToken();
            // 后端传回密码和token，验证token有效性
            this.$http.post('/api/admin/resetpwd', params)
              .then((response) => {
                console.log(response.data);
                if (response.data.err === OK && response.data.data > 0) {
                  this.$Message.success('密码重置成功!');
                  this.$router.push('/login');
                } else {
                  this.$Message.error(response.data.data);
                  this.$refs[name].resetFields();
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
      },
      // 验证地址栏中是否含有 token 参数
      _validateToken() {
        if (!this.$route.query.token) {
          this.$Message.warning('非法访问，请重试');
          this.$router.push('/login');
        }
      }
    },
    created() {
      console.log(this.$route.query.token);
      this._validateToken();
    }
  };
</script>

<style lang="sass" rel="stylesheet/scss">
  @import "login"
</style>
