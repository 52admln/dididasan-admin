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
        $data = json_decode($this->input->raw_input_stream);
//        $username = $this->input->post_get('username', TRUE);
        $username = $data->username;
//        $password = $this->input->post_get('password', TRUE);
        $password = $data->password;
        $where_array = array('username' => $username, 'password' => sha1($password));
        $query = $this->db->get_where('admin', $where_array);
        if (!$query) {
            $error = 1; // ERROR
        } else {
            $error = 0; // OK
        }
        return array('err' => $error, "data" => $query->num_rows());
    }

    public function changePwd()
    {
        $username = $this->input->post_get('username', TRUE);
        $oldpwd = $this->input->post_get('oldpwd', TRUE);
        $newpwd = $this->input->post_get('newpwd', TRUE);
        $where_array = array('username' => $username, 'password' => sha1($oldpwd));
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

        $this->db->where('username', $username);
        $this->db->update('admin', $data);
        $result = $this->db->affected_rows();
        return array('err' => $error, "data" => $result);
    }


}