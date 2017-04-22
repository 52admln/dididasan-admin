<template>
  <div class="user-list">
    <Row>
      <Col span="24">
      <Spin fix v-show="!loading">
        <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
        <div>数据加载中...</div>
      </Spin>
      <Table border :context="self" :columns="tableColumns" :data="userData" v-show="loading">
      </Table>
      <div style="margin: 10px;overflow: hidden">
        <div style="float: right;" v-show="loading">
          <Page :total="total" :current="currentPage" :page-size="pageSize" @on-change="changePage"></Page>
        </div>
      </div>
      </Col>
    </Row>
    <!-- 删除确认 -->
    <Modal v-model="delModel" width="360">
      <p slot="header" style="color:#f60;text-align:center">
        <Icon type="information-circled"></Icon>
        <span>删除确认</span>
      </p>
      <div style="text-align:center">
        <p>此用户删除后，所有记录将无法恢复。</p>
        <p>是否继续删除？</p>
      </div>
      <div slot="footer">
        <Button type="error" size="large" long :loading="delModel_loading" @click="removeConfirm">删除</Button>
      </div>
    </Modal>
    <!-- 用户资料修改 -->
    <Modal v-model="updateModel"
           title="用户资料修改"
           :mask-closable="false"
           :styles="{top: '10px'}">
      <!-- form表单-->
      <Form :model="updateUser" :label-width="80" class="form">
        <Form-item label="用户名" prop="username">
          <Input v-model="updateUser.username" placeholder="请输入用户名"></Input>
        </Form-item>
        <Form-item label="密码" prop="password">
          <Input type="password" v-model="updateUser.newPwd" placeholder="不修改密码则留空"></Input>
        </Form-item>
        <Form-item label="确认密码" prop="confirm_password">
          <Input v-model="updateUser.confirm_newPwd" placeholder="请再次输入新密码"></Input>
        </Form-item>
        <Form-item label="性别" prop="sex">
          <Radio-group v-model="updateUser.sex">
            <Radio v-for="item in sexList" :label="item.value" :key="item">{{ item.label }}</Radio>
          </Radio-group>
        </Form-item>
        <Form-item label="手机号码" prop="phone">
          <Input v-model="updateUser.telephone" placeholder="请输入手机号"></Input>
        </Form-item>
        <Form-item label="个性签名" prop="slogan">
          <Input v-model="updateUser.slogan" placeholder="请输入个性签名"></Input>
        </Form-item>
        <Form-item label="所在学院" prop="school">
          <Input v-model="updateUser.school" placeholder="请输入所在学院"></Input>
        </Form-item>
        <Form-item label="常去地址" prop="user_location">
          <Input v-model="updateUser.user_location" placeholder="请输入常去地址"></Input>
        </Form-item>
        <Form-item label="搜索异性" prop="allowed">
          <Radio-group v-model="updateUser.allowed">
            <Radio label="0">禁止</Radio>
            <Radio label="1">允许</Radio>
          </Radio-group>
        </Form-item>
      </Form>
      <div slot="footer">
        <Button type="primary" :loading="updateModel_loading" @click="updateConfirm">提交</Button>
        <Button @click="closeUpdateModel">关闭</Button>
      </div>
    </Modal>
  </div>
</template>

<script type="text/ecmascript-6">
  // todo 增加用户搜索查询（用户名、电话查询）
  const OK = 0; // 返回数据正常

  export default {
    data () {
      return {
        self: this,
        loading: false,
        currentPage: 1,
        total: 5,
        pageSize: 6,
        delModel: false, // 删除确认
        delModel_loading: false,
        updateModel: false, // 修改资料
        updateModel_loading: false,
        del_index: 0,
        del_id: 0,
        tableColumns: [
          {
            type: 'selection',
            width: 60,
            align: 'center'
          },
          {
            title: '用户 ID',
            key: 'user_id'
          },
          {
            title: '用户名',
            key: 'username'
          },
          {
            title: '性别',
            key: 'sex',
            render (row, column, index) {
              const sex = row.sex === '1' ? '女' : '男';
              return `${sex}`;
            }
          },
          {
            title: '电话',
            key: 'telephone'
          },
          {
            title: '所在学院',
            key: 'school'
          },
          {
            title: '搜索异性',
            key: 'allowed',
            render (row) {
              const color = row.allowed === '1' ? 'green' : 'red';
              const text = row.allowed === '1' ? '允许' : '禁止';
              return `<tag type="dot" color="${color}">${text}</tag>`;
            }
          },
          {
            title: '操作',
            key: 'action',
            width: 180,
            align: 'center',
            render (row, column, index) {
              return `<i-button size="small" @click="show(${index})">详情</i-button>
                      <i-button type="primary" size="small" @click="update(${index})">修改</i-button>
                      <i-button type="error" size="small" @click="remove(${index})">删除</i-button>`
                .trim();
            }
          }
        ],
        userData: [],
        updateUser: {
          newPwd: '',
          confirm_newPwd: ''
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
        ]
      };
    },
    methods: {
      show (index) {
        const avatar = this.userData[index].avatar === null ? 'img/noavatar_big.gif' : this.userData[index].avatar;
        const slogan = this.userData[index].slogan === null ? '暂无' : this.userData[index].slogan;
        const location = this.userData[index].user_location === null ? '暂无' : this.userData[index].user_location;
        this.$Modal.info({
          title: '用户信息',
          content: `<div class="avatar"><img src="http://localhost/DiDiDaSan/${avatar}" alt=""></div>
                    <div class="other-info"><p><strong>个性签名：</strong>${slogan}</p><p><strong>常去地址：</strong>${location}</p></div>`.trim()
        });
      },
      removeConfirm() {
        this.delModel_loading = true;
        // 删除操作提交到后台

        this.$http.get('/api/user/del', {
          params: {
            user_id: this.del_id
          }
        })
          .then((response) => {
            console.log(response.data.data);
            if (response.data.data > 0 && response.data.err === OK) {
              this.$Message.success('删除成功');
              this.userData.splice(this.del_index, 1);
              this.delModel_loading = false;
              this.delModel = false;
            }
          })
          .catch((error) => {
            console.log(error);
            this.delModel_loading = false;
            this.delModel = false;
            this.$Message.error('删除失败');
          });
      },
      remove (index) {
        this.delModel = true;
        this.del_index = index;
        this.del_id = this.userData[index].user_id;
      },
      closeUpdateModel() {
        this.updateModel = false;
      },
      updateConfirm () {
        // 执行修改操作，获取用户数据，往后台传
        //        allowed
        //        avatar
        //        confirm_newPwd
        //        newPwd
        //        password
        //        school
        //        sex
        //        slogan
        //        telephone
        //        user_id
        //        user_location
        //        username
        // todo 如果填写了密码，需要进行表单验证，并且修改后台密码

        // 提交操作
        const params = new URLSearchParams();
        params.append('username', this.updateUser.username);
        params.append('user_location', this.updateUser.user_location);
        params.append('telephone', this.updateUser.telephone);
        params.append('slogan', this.updateUser.slogan);
        params.append('sex', this.updateUser.sex);
        params.append('school', this.updateUser.school);
        params.append('allowed', this.updateUser.allowed);
        params.append('user_id', this.updateUser.user_id);

        if (this.updateUser.newPwd !== '') {
          // 密码不为空的时候，修改密码
          params.append('password', this.updateUser.newPwd); // 新密码
        }
        this.updateModel_loading = true;
        this.$http.post('/api/user/update', params)
          .then((response) => {
            console.log(response.data);
            if (response.data.err === 0 && response.data.data > 0) {
              // 完成修改后异步操作  ,数据存储在 updateUser当中
              this.updateModel = false;
              this.$Message.success('提交成功');
              this.updateModel_loading = false;
              this.getData();
            } else {
              this.$Message.error('修改错误，请重试');
              this.updateModel_loading = false;
            }
          })
          .catch((error) => {
            console.log(error);
          });
      },
      update(index) {
        this.btnLoading = true;
        // 获取到用户id，提交后台获取当前用户的值
        let userId = this.userData[index].user_id;
        console.log(this.userData[index].user_id);
        const loadingMsg = this.$Message.loading('正在加载中...', 0);
        this.$http.get('/api/user', {
          params: {
            user_id: userId
          }
        })
          .then((response) => {
            let newData = response.data.data[0];
            this.updateUser = Object.assign({}, this.updateUser, newData);
            console.log(this.updateUser);
            loadingMsg();
            this.updateModel = true;
          })
          .catch((error) => {
            console.log(error);
          });
      },
      changePage (curPage) {
        // 这里直接更改了模拟的数据，真实使用场景应该从服务端获取数据
        // this.userData = this.mockTableData1();
        console.log(curPage);
        // 往后台传2各参数，每页显示条数和当前页码
        this.$http.get('/api/user', {
          params: {
            current: curPage,
            page_size: this.pageSize
          }
        })
          .then((response) => {
            this.userData = response.data.data;
            this.total = response.data.total;
          })
          .catch((error) => {
            console.log(error);
          });
      },
      getData() {
        this.$http.get('/api/user', {
          params: {
            current: this.currentPage,
            page_size: this.pageSize
          }
        })
          .then((response) => {
            this.userData = response.data.data;
            this.total = response.data.total;
            this.loading = true;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    created() {
      this.getData();
    }
  };
</script>

<style lang="sass" rel="stylesheet/scss">
  @import "user"
</style>
