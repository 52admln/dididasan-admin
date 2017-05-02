<?php
class Record extends CI_Controller
{

    public function index()
    {
        $this->load->model('record_model');

        $header = $this->input->get_request_header('Authorization', TRUE);
      list($token) = sscanf($header, 'token %s');
      if ($header != '' && jwt_helper::validate($token)) {
            $result = $this->record_model->index();
            echo json_encode($result);
        } else {
            show_error("Permission denied", 401, "Please check your token.");
        }

    }

    public function del() {
        $this->load->model('record_model');

        $header = $this->input->get_request_header('Authorization', TRUE);
      list($token) = sscanf($header, 'token %s');
      if ($header != '' && jwt_helper::validate($token)) {
            $result = $this->record_model->del();
            echo json_encode($result);
        } else {
            show_error("Permission denied", 401, "Please check your token.");
        }

    }
}
