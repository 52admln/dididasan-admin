<?php

class Admin extends CI_Controller
{
  public function login()
  {
    $this->load->model('admin_model');
    $userid = $this->admin_model->login();

    if ($userid != false) {
      $token = jwt_helper::create($userid);
      $error = 0;
      echo json_encode(array('err' => $error, "token" => $token));
    } else {
      $error = 1;
      echo json_encode(array('err' => $error, "message" => "登录失败"));
    }
  }

  public function changepwd()
  {
    $this->load->model('admin_model');
    $header = $this->input->get_request_header('Authorization', TRUE);
    list($token) = sscanf($header, 'token %s');
    if ($header != '' && jwt_helper::validate($token)) {
      $userid = jwt_helper::decode($header)->userId;
      $result = $this->admin_model->changePwd($userid);
      echo json_encode($result);
    } else {
      show_error("Permission denied", 401, "Please check your token.");
    }

  }

  public function resetpwd()
  {
    $this->load->model('admin_model');
    $token = $this->input->post_get('token', TRUE);
    if ($token != '' && jwt_helper::validate($token)) {
      $userid = jwt_helper::decode($token)->userId;
      $result = $this->admin_model->resetPwd($userid, $token);
      echo json_encode($result);

    } else {
      show_error("Permission denied", 401, "Please check your token.");
    }
  }

  public function findpwd()
  {
    $this->load->model('admin_model');
    $mail = $this->input->post_get('mail', TRUE);
    $result = $this->admin_model->findPwd($mail);

    if ($result['err'] > 0) {
      echo json_encode(array('err' => $result['err'], "data" => $result['data']));
    }
    $token = jwt_helper::create($result['data']);

    // 将邮箱 token 存入数据库
    $this->admin_model->storeReset($mail, $token);

    // 发送邮件
    $mail_result = $this->sendEmail("1911938257@qq.com", $token);
    // 返回结果
    if ($mail_result == 0) {
      echo json_encode(array('err' => 0, "data" => "发送成功"));
    } else {
      echo json_encode(array('err' => 1, "data" => "发送失败"));
    }
  }


  public function sendEmail($mailto, $token)
  {
    $this->load->library('email');
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.qq.com';
    $config['smtp_user'] = '1911938257@qq.com';
    $config['smtp_pass'] = 'pwvsugsxtwldfbdf';
    $config['smtp_port'] = 465;
    $config['smtp_timeout'] = 30;
    $config['mailtype'] = 'text';
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['newline'] = PHP_EOL;
    $config['crlf'] = "\r\n";
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('1911938257@qq.com', '滴滴打伞');
    $this->email->to($mailto);
    $this->email->subject('[滴滴打伞]重置密码邮件');// 发送标题
    $this->email->message('重置密码地址：http://wyj.dev/#/findpwd?token=' . $token);//内容
    $this->email->send();
    $status = $this->email->print_debugger();
    if ($status) {
      return 0;
    } else {
      return 1;
    }
  }

}
