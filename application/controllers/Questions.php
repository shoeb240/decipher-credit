<?php
class questions extends Base {

    public function __construct()
    {
            parent::__construct();
             $this->load->model('ion_auth_model');
            if (!$this->ion_auth->logged_in()){
              redirect('auth/login');
            }

            $this->load->model('questions_model');
            $this->load->helper('url_helper');
 //           $this->load->view('common/header');
            $this->load->view('templates/head');
    }

    public function index()
    {
    }

            public function view($slug = NULL)
       {
            
                $data['questions'] = $this->questions_model->get_questions();
                $this->load->view('questions/view', $data);
        }


    public function create() 
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
    //    $this->load->view('common/header');

        $data['title'] = 'Create a question item';

        $this->form_validation->set_rules('des', 'des', 'required');
        $this->form_validation->set_rules('content', 'content', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['output_types'] = $this->questions_model->get_output_types();
            $data['statuses'] = $this->questions_model->get_statuses();
            $this->load->view('questions/create', $data);
        } else {
            $this->questions_model->set_question();
            $this->load->view('questions/success');
        }
    }


    public function edit($id)
    {
        if (!$this->ion_auth->logged_in()){
            redirect('auth/login', 'refresh');
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Edit a question item';

        $this->form_validation->set_rules('des', 'des', 'required');
        $this->form_validation->set_rules('content', 'content', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['question'] = $this->questions_model->get_question_row($id);
            $data['output_types'] = $this->questions_model->get_output_types();
            $data['statuses'] = $this->questions_model->get_statuses();
            
            $this->load->view('questions/edit', $data);
        } else {
            $data = array(
                'des' => $this->input->post('des'),
                'type' => $this->input->post('type'),
                'weight' => $this->input->post('weight'),
                'outputType' => $this->input->post('outputType'),
                'status' => $this->input->post('status'),
                'parameters' => $this->input->post('parameters'),
                'content' => $this->input->post('content'),
            );
            $this->questions_model->update_qustion($data, $id);

            $data["msg"] = "Question Updated.";
            $this->load->view('questions/success', $data);
        }

    }


}
