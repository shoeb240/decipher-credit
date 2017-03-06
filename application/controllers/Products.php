<?php
class Products extends Base {

        public function __construct()
        {
                parent::__construct();
                if (!$this->ion_auth->logged_in()){
                  redirect('auth/login');
                }
                if(!$this->ion_auth->is_admin() ) { 
                    redirect('auth', 'refresh');
                }
                
              $this->load->model('products_model');
//                $this->load->model('handlersextended_model');
                $this->load->helper('url_helper');
                $this->load->view('templates/head');
        }

        public function index()
        {
               $data['products'] = json_decode($this->products_model->getList());
               $this->load->view('products/index', $data);
        }
        

        public function checklist($prodid = null){
                $data['productchecklist'] = json_decode($this->products_model->cl2($prodid));
                $this->load->view('products/checklist', $data);
        }

  
  
}