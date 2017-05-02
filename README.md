# dididasan-admin
校园 Web App 滴滴打伞管理端

> A web app for student

# 功能


## 运行编译

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

```

# API
## 登录
### 后台
 `/api/admin/login` 后台登录
 
 `/api/admin/changepwd` 修改密码
 
 `/api/admin/findpwd` 找回密码
 
 `/api/admin/resetpwd` 重置密码
 
### 用户
 `/api/user` 获取全部用户信息
 
 `/api/user/add` 新增用户
 
 `/api/user/update` 更新用户
 
 `/api/user/del` 删除用户
 
 `/api/user/validate/` 验证是否被注册
 
### 记录
 `/api/record` 获取记录
 
 `/api/record/del` 删除记录

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

(需要注意，先删除外键的记录，再删除主键的记录)

### 问题5

CI 框架使用 SMTP 发送邮件
 
SMTP 服务器为 QQ邮箱

```
  public function sendEmail($mailto, $token)
  {
    $this->load->library('email');
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.qq.com';
    $config['smtp_user'] = '10086@qq.com';
    $config['smtp_pass'] = '**********';
    // 填写腾讯邮箱开启POP3/SMTP服务时的授权码，即核对密码正确 在邮箱设置 账号里面 
    $config['smtp_port'] = 465;
    $config['smtp_timeout'] = 30;
    $config['mailtype'] = 'text';
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['newline'] = PHP_EOL;
    $config['crlf'] = "\r\n";
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('10086@qq.com', '滴滴打伞');
    $this->email->to($mailto);
    $this->email->subject('[滴滴打伞]重置密码邮件');// 发送标题
    $this->email->message('重置密码地址：http://wyj.dev/#/findpwd?token=' . $token);//内容
    $this->email->send();
    $status = $this->email->print_debugger();
    if ($status) {
      echo 0;
    } else {
      echo 1;
    }
  }
```

