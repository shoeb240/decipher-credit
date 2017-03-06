<?php

class Applications extends Base {
    public function __construct() {
        parent::__construct();
        $this->load->model('ion_auth_model');
        if (!$this->ion_auth->logged_in()){
            redirect('auth/login');
        }

        $this->load->model('applications_model');
        $this->load->helper('url_helper');
        $this->load->model('customer_model');

        $this->customer_id =  $this->customer_model->get_customerid_fromuserid($this->ion_auth->get_user_id());
        $this->is_admin = $this->ion_auth->is_admin();
    }

    public function index() {
        $data['applications'] = $this->applications_model->get_applications($this->customer_id, $this->is_admin);
        $this->load->view('applications/index', $data);
        $this->load->view('common/treeview-css', $data);
    }

    public function applicant($application_id = NULL) {
        if (!$application_id) {
            redirect('applications/index');
        }
        $data['application_id'] = $application_id;
        $data['applications'] = $this->applications_model->get_application_by_id($this->customer_id, $application_id, $this->is_admin);
        $data['sections'] = json_encode($this->applications_model->get_section_questions_by_appid($application_id));

        $this->load->view('applications/applicant', $data);
        $this->load->view('common/treeview-css', $data);
    }

    public function question($questionId = NULL) {
        if (!$questionId) {
            redirect('applications/index');
        }

        $data['questionId'] = $questionId;
        $data['applications'] = $this->applications_model->get_application_by_id($this->customer_id, null, $this->is_admin, $questionId);
        $data['answers'] = $this->applications_model->get_question_answers($questionId);
        $this->load->view('applications/question', $data);
    }
    
    public function checklist($application_id = NULL) {
        if (!$application_id) {
            redirect('applications/index');
        }
        $data['applications'] = $this->applications_model->get_application_by_id($this->customer_id, $application_id);               
        $data['checklists'] = $this->applications_model->get_checklists($application_id);               
        $this->load->view('applications/checklist', $data);
    }
}





