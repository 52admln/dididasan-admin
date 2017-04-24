<?php
class Record extends CI_Controller
{
    public function index()
    {
        $this->load->model('record_model');
        $result = $this->record_model->index();
        echo json_encode($result);
    }
    public function del() {
        $this->load->model('record_model');
        $result = $this->record_model->del();
        echo json_encode($result);
    }
}