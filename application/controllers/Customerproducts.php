<?php

class Customerproducts extends Base {
	private $customer_id;

        public function __construct(){
                parent::__construct();
                $this->load->model('ion_auth_model');
                if (!$this->ion_auth->logged_in()){
                	redirect('auth/login');
                }
                $this->load->model('CustomerProducts_model');
                $this->load->model('Customer_model');
                $user = $this->ion_auth->user()->row();
                $this->customer_id = $this->Customer_model->get_customerid_fromuserid($user->id);
        }

        public function index(){
            $this->CustomerProducts_model->customer = $this->customer_id;
            $data['products'] = json_decode($this->CustomerProducts_model->get_products());
            $this->load->view('customer/products/customerproduct_view', $data);
        }
        
         public function checklist($prodid = null){
            $this->CustomerProducts_model->product = $prodid;
            $this->CustomerProducts_model->customer = $this->customer_id;
            $data['productchecklist'] = json_decode($this->CustomerProducts_model->get_checklist());
            $this->load->view('customer/products/customerproduct_checklist', $data);
        }
        


}
?>