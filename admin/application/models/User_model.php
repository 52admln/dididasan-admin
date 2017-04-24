<?php

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
    }

    // 获取用户
    public function get_users()
    {
        // 如果传入用户ID,返回当前用户的信息
        $currentUser = $this->input->post_get('user_id', TRUE);
        // 参数1: $currentPage 当前页码, 参数2: $pageSize 每页显示条数
        // 如果有参数,则返回分页的数据,没有返回全部数据
        $currentPage = $this->input->post_get('current', TRUE);
        $pageSize = $this->input->post_get('page_size', TRUE);
        $total_query = $this->db->get('users');
        $total = $total_query->num_rows();

        // 如果传入用户ID,返回当前用户的信息
        if ($currentUser != '') {
            // 返回全部数据
            $query = $this->db->where('user_id', $currentUser)
                ->get('users');
            if (!$query) {
                $error = 1; // ERROR
            } else {
                $error = 0; // OK
            }
            return array('err' => $error, "data" => $query->result_array(), "total" => $total);
        }

        if ($currentPage == '' && $pageSize == '') {
            // 返回全部数据
            $query = $this->db->get('users');
            if (!$query) {
                $error = 1; // ERROR
            } else {
                $error = 0; // OK
            }
            return array('err' => $error, "data" => $query->result_array(), "total" => $total);
        }
        // 返回指定数据
        $offsetRows = $pageSize * ($currentPage - 1); // 数据偏移量
        $query = $this->db->limit($pageSize, $offsetRows)
            ->get('users');

        if (!$query) {
            $error = 1; // ERROR
        } else {
            $error = 0; // OK
        }
        return array('err' => $error, "data" => $query->result_array(), "total" => $total);

    }

    // 新增用户
    public function add_user()
    {
        // get POST data
        $username = $this->input->post_get('username', TRUE);
        $password = $this->input->post_get('password', TRUE);
        $sex = $this->input->post_get('sex', TRUE);
        $phone = $this->input->post_get('phone', TRUE);
        if ($username == null || $password == null || $sex == null || $phone == null) {
            return array('err' => 1, "data" => '参数未传入');
        }
        // insert

        $is_exist = $this->db->get_where('users', array('username' => $username));
        if ($is_exist->num_rows() > 0) {
            return array('err' => 2, "data" => '用户名已存在');
        }
        $data = array(
            'username' => $username,
            'password' => sha1($password),
            'sex' => $sex,
            'telephone' => $phone,
            'avatar' => 'img/noavatar_big.gif'
        );

        $query = $this->db->insert('users', $data);

        if (!$query) {
            $error = 1; // ERROR
        } else {
            $error = 0; // OK
        }
        return array('err' => $error, "data" => $query);
    }

    // 修改用户
    public function update_user()
    {
        // todo 分两种情况,一种是修改密码,一种是不修改密码
        // todo 更新数据

        // 不修改密码
        //获取数据
        $username = $this->input->post_get('username', TRUE);
        $user_location = $this->input->post_get('user_location', TRUE);
        $telephone = $this->input->post_get('telephone', TRUE);
        $slogan = $this->input->post_get('slogan', TRUE);
        $sex = $this->input->post_get('sex', TRUE);
        $school = $this->input->post_get('school', TRUE);
        $allowed = $this->input->post_get('allowed', TRUE);
        $user_id = $this->input->post_get('user_id', TRUE);
        $password = $this->input->post_get('password', TRUE) == null ? '' : $this->input->post_get('password', TRUE);
        // 密码为空,则不修改密码
        if ($password == '') {
            $data = array(
                'username' => $username,
                'user_location' => $user_location,
                'telephone' => $telephone,
                'slogan' => $slogan,
                'sex' => $sex,
                'school' => $school,
                'allowed' => $allowed
            );
        } else {
            $data = array(
                'username' => $username,
                'user_location' => $user_location,
                'telephone' => $telephone,
                'slogan' => $slogan,
                'sex' => $sex,
                'school' => $school,
                'allowed' => $allowed,
                'password' => sha1($password)
            );
        }


        $this->db->where('user_id', $user_id);
        $query = $this->db->update('users', $data);
        if (!$query) {
            $error = 1; // ERROR
        } else {
            $error = 0; // OK
        }
        $result = $this->db->affected_rows();
        return array('err' => $error, "data" => $result);

    }

    // 删除用户
    public function del_user()
    {
        $user_id = $this->input->post_get('user_id', TRUE);
        // 删除多表中的数据
//        $del_tables = array('users', 'helper');
//        $this->db->where('user_id', $user_id);
//        $this->db->delete($del_tables);
//        $result = $this->db->affected_rows();

        $this->db->query("DELETE users,helper FROM users LEFT JOIN helper ON users.user_id=helper.user_id WHERE users.user_id={$user_id}");
        $rows = $this->db->affected_rows();


        if ($rows != 0) {
            $error = 0; // OK
        } else {
            $error = 1; // ERROR
        }
        return array('err' => $error, "data" => $rows);
    }

    // 异步验证用户名是否被注册
    public function validate_user()
    {
        $username = $this->input->post_get('username', TRUE);
        $is_exist = $this->db->get_where('users', array('username' => $username));
        if ($is_exist->num_rows() > 0) {
            return array('err' => 1, "data" => '用户名已存在');
        } else {
            return array('err' => 0, "data" => '可以注册!');
        }
    }

}