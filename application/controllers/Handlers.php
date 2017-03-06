<?php


class Handlers extends Base {

        public function __construct()
        {
                parent::__construct();
                if (!$this->ion_auth->logged_in()){
                  redirect('auth/login');
                }
                if(!$this->ion_auth->is_admin() ) { 
                    redirect('auth', 'refresh');
                }
                
                $this->load->model('handlers_model');
                $this->load->model('handlersextended_model');
                $this->load->helper('url_helper');
                $this->load->view('templates/head');
        }

        public function index()
        {
                $data['all'] = $this->handlersextended_model->score();
                $this->load->view('handlers/base', $data);
        }

        public function view($handlerID = NULL){
                if (!$this->ion_auth->logged_in()){
                   redirect('auth/login');
                }
                $data['handlers'] = $this->handlers_model->get_handlers_usage();
                $this->load->view('handlers/view', $data);
        }

        public function create(){ 
            $this->load->helper('form');
            $this->load->library('form_validation');
            $data['title'] = 'Create a question handler';
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('handler', 'handler', 'required');
            if ($this->form_validation->run() === FALSE){
                $this->load->view('handlers/create',$data);
            }else{
                $hand_data = array(
                    'description' => $this->input->post('description'),
                    'handler' => $this->input->post('handler'),
                );

                $handler_id =  $this->handlers_model->set_handler($hand_data);

                $data["msg"] = "Handler Added.";
                $this->load->view('handlers/success',$data);
            }
        }

        public function edit($handler_id)
        {   
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('handler', 'handler', 'required');
             
            if ($this->form_validation->run() === FALSE)
            {   
                $data["hand_data"] = json_decode($this->handlers_model->get_handlerDataById($handler_id));
                
                $this->load->view('handlers/edit',$data);
            }
            else        
            {
                $update_data = array(
                    'description' => $this->input->post('description'),
                    'handler' => $this->input->post('handler'),
                );
                
                $this->handlers_model->update_handler($update_data,$handler_id);
                
                $data["msg"] = "Handler Updated.";
                $this->load->view('handlers/success',$data);
            }
        }

}