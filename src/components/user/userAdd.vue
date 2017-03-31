<template>
  <div>
    <Form :model="userData" ref="addUser" :rules="ruleCustom" :label-width="80" class="form">
      <Form-item label="用户名" prop="username">
        <Input v-model="userData.username" placeholder="请输入用户名"></Input>
      </Form-item>
      <Form-item label="密码" prop="password">
        <Input v-model="userData.password" placeholder="请输入密码"></Input>
      </Form-item>
      <Form-item label="确认密码" prop="confirm_password">
        <Input v-model="userData.confirm_password" placeholder="再次输入密码"></Input>
      </Form-item>
      <Form-item label="性别" prop="sex">
        <Radio-group v-model="userData.sex">
          <Radio v-for="item in sexList" :label="item.value" :key="item">{{ item.label }}</Radio>
        </Radio-group>
      </Form-item>
      <Form-item label="手机号码" prop="phone">
        <Input v-model="userData.phone" placeholder="请输入手机号"></Input>
      </Form-item>
      <Form-item>
        <Button type="primary" @click="handleSubmit('addUser')">提交</Button>
        <Button type="ghost" style="margin-left: 8px">取消</Button>
      </Form-item>
    </Form>
  </div>
</template>

<script type="text/ecmascript-6">
  const OK = 0; // 返回数据正常

  export default {
    data () {
      const validatePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码,长度6-25个字符'));
        } else {
          if (this.userData.confirm_password !== '') {
            // 对第二个密码框单独验证
            this.$refs.addUser.validateField('confirm_password');
          }
          callback();
        }
      };
      const validatePassCheck = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码,密码长度6-25个字符'));
        } else if (value !== this.userData.password) {
          callback(new Error('两次输入密码不一致!'));
        } else {
          callback();
        }
      };
      const validateUser = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('请输入用户名'));
        }
        // 模拟异步验证效果
        if (!/^[a-zA-Z]+[a-zA-Z0-9_]{2,10}$/.test(value)) {
          callback(new Error('长度2-10位字母数字，以字母开头'));
        } else {
          const params = new URLSearchParams();
          params.append('username', this.userData.username);
          this.$http.post('/api/user/validate', params)
            .then((response) => {
              console.log(response.data);
              if (response.data.err === OK) {
                callback();
              } else {
                callback(new Error('用户名已被注册'));
              }
            })
            .catch((error) => {
              console.log(error);
            });
        }
      };

      return {
        userData: {
          username: '',
          password: '',
          confirm_password: '',
          sex: '',
          phone: ''
        },
        sexList: [
          {
            value: '0',
            label: '男'
          },
          {
            value: '1',
            label: '女'
          }
        ],
        ruleCustom: {
          username: [
            {required: true, validator: validateUser, trigger: 'blur'}
          ],
          password: [
            {required: true, validator: validatePass, min: 6, max: 25, trigger: 'blur'}
          ],
          confirm_password: [
            {required: true, validator: validatePassCheck, trigger: 'blur'}
          ],
          sex: [
            {required: true, message: '请选择性别', trigger: 'blur'}
          ],
          phone: [
            {required: true, message: '请输入正确手机号码', trigger: 'blur', pattern: /^1[3|4|5|7|8][0-9]\d{8}$/}
          ]
        }
      };
    },
    methods: {
      handleSubmit (name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
            this.$Message.success('提交成功!');
            // todo axios API
            const params = new URLSearchParams();
            params.append('username', this.userData.username);
            params.append('password', this.userData.password);
            params.append('sex', this.userData.sex);
            params.append('phone', this.userData.phone);
            this.$http.post('/api/user/add', params)
              .then((response) => {
                console.log(response.data);
                if (response.data.err === 0) {
                  this.$Message.success('添加成功!');
                  this.$refs[name].resetFields();
                } else {
                  this.$Message.error(response.data.data);
                }
              })
              .catch((error) => {
                console.log(error);
              });
          } else {
            this.$Message.error('表单填写有误，请检查!');
          }
        });
      }
    }
  };
</script>

<style>
  .form {
    width: 50%;
  }
</style>
