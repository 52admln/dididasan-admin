<?php

class Admin extends CI_Controller
{
    public function login()
    {
        $this->load->model('admin_model');
        $result = $this->admin_model->login();
        echo json_encode($result);
    }
    public function changepwd() {
        $this->load->model('admin_model');
        $result = $this->admin_model->changePwd();
        echo json_encode($result);
    }
    public function validate() {
        $this->load->model('admin_model');
        $result = $this->admin_model->validatePwd();
        echo json_encode($result);
    }

}