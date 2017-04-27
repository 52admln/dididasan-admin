<?php
class Record extends CI_Controller
{
    public function index()
    {
        $this->load->model('record_model');

        $header = $this->input->get_request_header('Authorization', TRUE);
        if ($header != '' && jwt_helper::validate($header)) {
            $result = $this->record_model->index();
            echo json_encode($result);
        } else {
            show_error("Permission denied", 401, "Please check your token.");
        }


    }
    public function del() {
        $this->load->model('record_model');

        $header = $this->input->get_request_header('Authorization', TRUE);
        if ($header != '' && jwt_helper::validate($header)) {
            $result = $this->record_model->del();
            echo json_encode($result);
        } else {
            show_error("Permission denied", 401, "Please check your token.");
        }

    }
}