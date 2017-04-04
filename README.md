# dididasan-admin
校园 Web App 滴滴打伞管理端

# didi-dasan

> A web app for student

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report
```

For detailed explanation on how things work, checkout the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).


# Problems

### 问题1： 

Vue 当中使用axios POST传参接收不到的问题
如果要用 application/x-www-form-urlencoded 格式发送数据，数据必须是 URLSearchParams 类型，或者字符串参数 a=1&b=2 格式。

参考：[axios - Using application/x-www-form-urlencoded format](https://github.com/mzabriskie/axios#using-applicationx-www-form-urlencoded-format)

```
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

```

### 问题2

ESLint 报错：no-undef 'URLSearchParams' is not defined

解决方法：https://segmentfault.com/q/1010000008159196

### 问题3

CI 框架删除数据无法返回映像行数

用系统的 


使用    
```
$this->db->query("DELETE users,helper FROM users LEFT JOIN helper ON users.user_id=helper.user_id WHERE users.user_id={$user_id}");
$rows=$this->db->affected_rows();
```


### 问题4

DELETE 多表数据

从两个表中找出相同记录的数据并把两个表中的数据都删除掉

DELETE t1,t2 FROM t1 LEFT JOIN t2 ON t1.id=t2.id WHERE t1.id=25 

注意此处的delete t1,t2 from 中的t1,t2不能是别名
