<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_ajax extends CI_Controller {
	
	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('ion_auth_model');
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login');
		}
		$this->load->model('customeruser_model');
                $this->load->library(array('ion_auth','form_validation'));
	}
	
	
	public function SaveCustomerUsers()
	{
            if(isset($_POST['user_id']) && isset($_POST['cust_id_list'])) {
                $custIdArr = explode(',', $_POST['cust_id_list']);
                $userData = array();
                foreach($custIdArr as $custId) {   
                    if ($custId) {
                        $userData[] = array(
                            'userID' => $_POST['user_id'],
                            'custID' => $custId,
                        );
                    }
                }
                
                try {
                    $result = $this->customeruser_model->set_customer_link_batch($userData, $_POST['user_id']);
                } catch(Exception $e) {
                    $result = false; //$e->getMessage();
                }
            } else {
                $result = false;
            }
            
            echo json_encode(array('response' => $result));
	}
		
        public function SaveCustomer()
        {
            $result = false;

            if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
            {
                $data = array();
                $customer_id = $_POST['customer_id'];

                // update the password if it was posted
                if ($this->input->post('nameLast'))
                {
                    $data['nameLast'] = urldecode($this->input->post('nameLast'));
                    $this->form_validation->set_rules('nameLast', 'Customer Name', 'required');
                }

                if ($this->form_validation->run() === TRUE)
                {
                    $this->customeruser_model->update_customer($data, $customer_id);
                    $result = true;
                }

            }

            echo json_encode(array('response' => $result));
        }

		
}
	