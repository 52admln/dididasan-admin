<?php

class Admin_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->load->database();
  }

  public function login()
  {
//        $data = json_decode($this->input->raw_input_stream);
    $username = $this->input->post_get('username', TRUE);
//        $username = $data->username;
    $password = $this->input->post_get('password', TRUE);
//        $password = $data->password;
    $where_array = array('username' => $username, 'password' => sha1($password));
    $query = $this->db->get_where('admin', $where_array);
    // 用户名密码正确后，生成token，返回给前台
    if ($query->num_rows() > 0) {
      return $query->first_row()->id;
    } else {
      return false;
    }
  }

  public function changePwd($userid)
  {
    $oldpwd = $this->input->post_get('oldpwd', TRUE);
    $newpwd = $this->input->post_get('newpwd', TRUE);
    $where_array = array('id' => $userid, 'password' => sha1($oldpwd));
    $query = $this->db->get_where('admin', $where_array);
    if (!$query) {
      $error = 1; // ERROR
    } else {
      $error = 0; // OK
    }
    // 如果返回结果大于0 , 则继续执行修改密码
    if ($query->num_rows() == 0) {
      return array('err' => $error, "data" => '原密码错误,请重试');
    }

    $data = array(
      'password' => sha1($newpwd)
    );
    $this->db->where('id', $userid);
    $this->db->update('admin', $data);
    $result = $this->db->affected_rows();
    return array('err' => $error, "data" => $result);
  }

  public function resetPwd($userid, $token)
  {
    $email = $this->input->post_get('email', TRUE);
    $passwd = $this->input->post_get('password', TRUE);
    $passwdCheck = $this->input->post_get('confirm_password', TRUE);
    $error = 0;
    if ($passwd != $passwdCheck) {
      $error = 1;
      return array('err' => $error, "data" => "两次密码不一致");
    }
    // 验证 用户邮箱 和 token
    $where_array = array('email' => $email, 'token' => $token);
    $query = $this->db->get_where('password_resets', $where_array);
    if ($query->num_rows() == 0) {
      $error = 1;
      return array('err' => $error, "data" => "重置密码请求已过期或不存在，请重新提交！");
    } else {
      // 如果存在记录，则删除，防止再次修改
      $this->db->delete('password_resets', array('email' => $email));
    }

    // 修改密码
    $newpass = sha1($passwd);
    $this->db->query("UPDATE admin SET password = '{$newpass}' WHERE id = {$userid}");
    $result = $this->db->affected_rows();
    if ($result == 0) {
      $error = 1;
      return array('err' => $error, "data" => '密码重置失败，与原密码相同,请重试');
    }
    return array('err' => $error, "data" => $result);
  }

  public function findPwd($mail)
  {
    $error = 0;
    if ($mail == '') {
      $error = 1;
      return array('err' => $error, "data" => "内容不能为空，请检查");
    }
    // 搜索数据库发现匹配项目
    $where_array = array('mail' => $mail);
    $query = $this->db->get_where('admin', $where_array);
    if ($query->num_rows() == 0) {
      $error = 1;
      return array('err' => $error, "data" => "找不到此用户，请检查");
    }

    // 返回 用户id
    $result = $query->first_row()->id;
    return array('err' => $error, "data" => $result);
  }

  // 存储重置密码请求
  public function storeReset($mail, $token)
  {
    $where_array = array('email' => $mail);
    $query = $this->db->get_where('password_resets', $where_array);
    // 已经存在记录，则删除重新添加
    if ($query->num_rows() > 0) {
      $data = array(
        'email' => $mail,
        'token' => $token,
        'created_at' => time()
      );
      $this->db->where('email', $mail);
      $this->db->update('password_resets', $data);
    } else {
      $insert_data = array(
        'email' => $mail,
        'token' => $token,
        'created_at' => time()
      );

      $this->db->insert('password_resets', $insert_data);
    }

  }
}
