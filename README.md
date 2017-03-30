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

