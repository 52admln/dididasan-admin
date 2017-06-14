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
          <Button type="primary" html-type="submit" @click="handleSubmit('formValidate')" long>立即登录</Button>
          <a @click.prevent="forgotPwd">忘记密码？</a>
        </Form-item>
      </Form>
    </div>
    <!-- 忘记密码 -->
    <Modal v-model="findpwd_modal"
           title="忘记密码？"
           :mask-closable="false"
    >
      <!-- form表单-->
      <Form ref="findPwd" :model="findPwd" :rules="findPwdValidate" :label-width="80" class="form">
        <Form-item label="邮箱" prop="mail">
          <Input v-model="findPwd.mail" placeholder="请输入绑定的邮箱"></Input>
        </Form-item>
      </Form>
      <div slot="footer">
        <Button type="primary" :loading="findpwd_loading" @click="handlePwd('findPwd')">提交</Button>
        <Button @click="closePwdModal">关闭</Button>
      </div>
    </Modal>
  </div>
</template>

<script>
  import qs from 'qs';
  const OK = 0; // 返回数据正常

  export default {
    data() {
      return {
        findpwd_loading: false,
        findpwd_modal: false,
        findPwd: {
          mail: ''
        },
        findPwdValidate: {
          mail: [
            {
              required: true,
              message: '请输入邮箱',
              trigger: 'blur',
              type: 'email'
            }
          ]
        },
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
      // 忘记密码
      handlePwd(name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
            this.findpwd_loading = true;
//            const params = new URLSearchParams();
//            params.append('mail', this.findPwd.mail);
            const params = qs.stringify({ 'mail': this.findPwd.mail });
            this.$http.post('/api/admin/findpwd', params)
              .then((response) => {
                console.log(response.data);
                if (response.data.err === OK) {
                  this.findpwd_modal = false;
                  this.$Message.success('提交成功');
                  this.findpwd_loading = false;
                } else {
                  this.$Message.error(response.data.data);
                  this.findpwd_loading = false;
                }
              })
              .catch((error) => {
                console.log(error);
                this.$Message.error('网络错误，请重试');
              });
          } else {
            this.$Message.error('表单填写有误!');
          }
        });
      },
      closePwdModal() {
        this.findpwd_modal = false;
      },
      handleSubmit(name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
//            const params = new URLSearchParams();
//            params.append('username', this.formValidate.username);
//            params.append('password', this.formValidate.password);
            const params = qs.stringify({ 'username': this.formValidate.username, 'password': this.formValidate.password });
            this.$http.post('/api/admin/login', params)
              .then((response) => {
                console.log(response.data);
                if (response.data.err === OK) {
                  this.$Message.success('登录成功!');
                  console.log(response.data);
                  const data = {
                    username: this.formValidate.username,
                    token: response.data.token
                  };
                  this.$store.dispatch('login', data);
                  // dispatch action，从action commit 到mutation更新登录状态
//                  this.$store.dispatch('login', this.formValidate.username);
                  this.$router.push('/index');
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
      },
      forgotPwd() {
        this.findpwd_modal = true;
      }
    }
  };
</script>

<style lang="sass" rel="stylesheet/scss">
  @import "login"
</style>
