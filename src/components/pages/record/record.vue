<template>
  <div class="record-list">
    <Row>
      <Col span="24">
      <Spin fix v-show="!loading">
        <Icon type="load-c" size=18  class="demo-spin-icon-load"></Icon>
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
  </div>
</template>

<script type="text/ecmascript-6">
  import {dateStr} from '../../../common/js/util';

  export default {
    data () {
      return {
        self: this,
        loading: false,
        currentPage: 1,
        total: 5,
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
            title: '性别',
            key: 'sex',
            width: '70',
            render (row, column, index) {
              const sex = row.sex === '1' ? '女' : '男';
              return `${sex}`;
            }
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
    computed: {
      type() {
        return this.$route.params.type;
      }
    },
    created() {
      this.fetchData();
    },
    watch: {
      '$route': 'fetchData'
    },
    methods: {
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
            type: this.$route.params.type,
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
        this.$http.get('/api/record', {
          params: {
            type: this.$route.params.type,
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
