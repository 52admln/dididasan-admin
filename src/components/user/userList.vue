<template>
  <div class="user-list">
    <Row>
      <Col span="24">
      <Table border :context="self" :columns="tableColumns" :data="userData"></Table>
      <div style="margin: 10px;overflow: hidden">
        <div style="float: right;">
          <Page :total="100" :current="1" @on-change="changePage"></Page>
        </div>
      </div>
      </Col>
    </Row>
  </div>
</template>

<script type="text/ecmascript-6">
  export default {
    data () {
      return {
        self: this,
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
                      <i-button type="primary"size="small" >修改</i-button>
                      <i-button type="error" size="small" @click="remove(${index})">删除</i-button>`
                .trim();
            }
          }
        ],
        userData: []
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
      remove (index) {
        this.userData.splice(index, 1);
      },
      changePage () {
        // 这里直接更改了模拟的数据，真实使用场景应该从服务端获取数据
        // this.userData = this.mockTableData1();
      }
    },
    created() {
      this.$http.get('/api/user')
        .then((response) => {
          this.userData = response.data.data;
          console.log(this.userData);
        })
        .catch((error) => {
          console.log(error);
        });
    }
  };
</script>

<style lang="sass" rel="stylesheet/scss">
  @import "user"
</style>
