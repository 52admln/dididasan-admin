<?php

class Record_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
    }

    public function index()
    {

        // 参数1: $currentPage 当前页码, 参数2: $pageSize 每页显示条数
        // 如果有参数,则返回分页的数据,没有返回全部数据
        $currentPage = $this->input->post_get('current', TRUE);
        $pageSize = $this->input->post_get('page_size', TRUE);
        $total_query = $this->db->query("SELECT users.username, helper.id, helper.location, helper.target,helper.id, helper.time, helper.itemtype FROM users, helper WHERE helper.user_id = users.user_id");
        $total = $total_query->num_rows();

        if ($currentPage == '' && $pageSize == '') {
            // 返回全部数据
            $query = $this->db->query("SELECT users.username, users.sex, helper.id, helper.location, helper.target,helper.id, helper.time, helper.itemtype FROM users, helper WHERE helper.user_id = users.user_id");
            if (!$query) {
                $error = 1; // ERROR
            } else {
                $error = 0; // OK
            }
            return array('err' => $error, "data" => $query->result_array(), "total" => $total);
        }
        // 返回指定数据
          $offsetRows = $pageSize * ($currentPage - 1); // 数据偏移量
        $query = $this->db->query("SELECT users.username, users.sex, helper.id, helper.location, helper.target,helper.id, helper.time, helper.itemtype FROM users, helper WHERE helper.user_id = users.user_id LIMIT {$offsetRows}, {$pageSize}");

        if (!$query) {
            $error = 1; // ERROR
        } else {
            $error = 0; // OK
        }
        return array('err' => $error, "data" => $query->result_array(), "total" => $total);


    }

    public function del()
    {
        // 记录id
        $id = $this->input->post_get('id', TRUE);

        $this->db->query("DELETE FROM helper WHERE id={$id}");
        $rows = $this->db->affected_rows();

        if ($rows != 0) {
            $error = 0; // OK
        } else {
            $error = 1; // ERROR
        }
        return array('err' => $error, "data" => $rows);

    }
}
