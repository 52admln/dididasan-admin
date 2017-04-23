<template>
  <div class="record-list">
    <Row>
      <Col span="24">
      <Spin fix v-show="!loading">
        <Icon type="load-c" size=18     class="demo-spin-icon-load"></Icon>
        <div>数据加载中...</div>
      </Spin>
      <Table border :context="self" :columns="tableColumns" :data="recordData" v-show="loading">
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
  </div>
</template>

<script type="text/ecmascript-6">
  import {dateStr} from '../../../common/js/util';
  const OK = 0; // 返回数据正常

  export default {
    data () {
      return {
        self: this,
        loading: false,
        currentPage: 1,
        total: 5,
        delModel: false, // 删除确认
        delModel_loading: false,
        pageSize: 5,
        del_index: 0,
        del_id: 0,
        tableColumns: [
          {
            type: 'selection',
            width: 60,
            align: 'center'
          },
          {
            title: 'ID',
            key: 'id',
            width: '70'
          },
          {
            title: '用户名',
            key: 'username'
          },
          {
            title: '出发地',
            key: 'location',
            width: '250',
            render (row, column, index) {
              const lnglatXY = row.location;
              return `${lnglatXY}
                      <i-button size="small" v-show="true" @click="showDetail(${index})">查看地址</i-button>
              `.trim();
            }
          },
          {
            title: '目的地',
            key: 'target'
          },
          {
            title: '类型',
            key: 'itemtype',
            render (row, column, index) {
              const itemtype = row.itemtype === 'helper' ? '帮助' : row.itemtype === 'needer' ? '求助' : '未知';
              const color = row.itemtype === 'helper' ? 'blue' : row.itemtype === 'needer' ? 'green' : 'red';
              return `<tag type="dot" color="${color}">${itemtype}</tag>`;
            },
            sortable: true,
            filters: [
              {
                label: '帮助记录',
                value: 1
              },
              {
                label: '求助记录',
                value: 2
              }
            ],
            filterMultiple: false,
            filterMethod (value, row) {
              if (value === 1) {
                return row.itemtype === 'helper';
              } else if (value === 2) {
                return row.itemtype === 'needer';
              }
            }
          },
          {
            title: '时间',
            key: 'time',
            render (row, colum, index) {
              const date = dateStr(row.time);
              return `${date}`;
            }
          },
          {
            title: '操作',
            key: 'action',
            width: 80,
            align: 'center',
            render (row, column, index) {
              return `<i-button type="error" size="small" @click="remove(${index})">删除</i-button>`
                .trim();
            }
          }
        ],
        recordData: [],
        updateUser: {
          newPwd: '',
          confirm_newPwd: ''
        }
      };
    },
    created() {
      this.fetchData();
    },
    watch: {
      '$route': 'fetchData'
    },
    methods: {
      removeConfirm() {
        this.delModel_loading = true;
        // 删除操作提交到后台

        this.$http.get('/api/record/del', {
          params: {
            id: this.del_id
          }
        })
          .then((response) => {
            console.log(response.data.data);
            if (response.data.data > 0 && response.data.err === OK) {
              this.$Message.success('删除成功');
              this.recordData.splice(this.del_index, 1);
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
        this.del_id = this.recordData[index].id;
      },
      showDetail(index) {
        console.log(index);
        const local = this.recordData[index].location;
        this.$http.get('http://restapi.amap.com/v3/geocode/regeo', {
          params: {
            key: '8575fbf3c738af2abb70e6fc7773cc85',
            location: local
          }
        })
          .then((response) => {
            const location = response.data.regeocode.formatted_address;
            this.recordData[index].location = location;
          })
          .catch((error) => {
            console.log(error);
          });
      },
      changePage (curPage) {
        // 这里直接更改了模拟的数据，真实使用场景应该从服务端获取数据
        console.log(curPage);
        // 往后台传2各参数，每页显示条数和当前页码
        this.$http.get('/api/record', {
          params: {
            current: curPage,
            page_size: this.pageSize
          }
        })
          .then((response) => {
            this.recordData = response.data.data;
            this.total = response.data.total;
          })
          .catch((error) => {
            console.log(error);
          });
      },
      fetchData() {
        // 初始化 页码 为 1
        this.currentPage = 1;
        // 从后台获取数据
        this.$http.get('/api/record', {
          params: {
            current: this.currentPage,
            page_size: this.pageSize
          }
        })
          .then((response) => {
            this.recordData = response.data.data;
            this.total = response.data.total;
            this.loading = true;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    }
  };
</script>

<style lang="sass" rel="stylesheet/scss">

</style>
