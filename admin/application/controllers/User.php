<?php

class User extends CI_Controller
{
    // 获取所有用户
    public function index()
    {
        $this->load->model('user_model');

        $header = $this->input->get_request_header('Authorization', TRUE);
        if ($header != '' && jwt_helper::validate($header)) {
            $result = $this->user_model->get_users();
            echo json_encode($result);
        } else {
            show_error("Permission denied", 401, "Please check your token.");
        }
    }

    // 新增用户
    public function add()
    {
        $this->load->model('user_model');

        $header = $this->input->get_request_header('Authorization', TRUE);
        if ($header != '' && jwt_helper::validate($header)) {
                $result = $this->user_model->add_user();
                echo json_encode($result);
        } else {
            show_error("Permission denied", 401, "Please check your token.");
        }

    }

    // 修改用户
    public function update()
    {
        $this->load->model('user_model');

        $header = $this->input->get_request_header('Authorization', TRUE);
        if ($header != '' && jwt_helper::validate($header)) {
            $result = $this->user_model->update_user();
            echo json_encode($result);
        } else {
            show_error("Permission denied", 401, "Please check your token.");
        }

    }

    // 修改用户
    public function del()
    {
        $this->load->model('user_model');

        $header = $this->input->get_request_header('Authorization', TRUE);
        if ($header != '' && jwt_helper::validate($header)) {
            $result = $this->user_model->del_user();
            echo json_encode($result);
        } else {
            show_error("Permission denied", 401, "Please check your token.");
        }

    }

    // 异步验证用户名是否被注册
    public function validate()
    {
        $this->load->model('user_model');

        $header = $this->input->get_request_header('Authorization', TRUE);
        if ($header != '' && jwt_helper::validate($header)) {
            $result = $this->user_model->validate_user();
            echo json_encode($result);
        } else {
            show_error("Permission denied", 401, "Please check your token.");
        }


    }


}