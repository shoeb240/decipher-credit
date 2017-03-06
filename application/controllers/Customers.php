<?php


class Customers extends Base {

    
    

         public function __construct(){
                parent::__construct();
                 $this->load->model('ion_auth_model');
                if (!$this->ion_auth->logged_in()){
//                  redirect('auth/login');
                }
                $this->load->model("customertemplates_model");
                $this->load->model('customersections_model');
                $this->load->model("customer_model");
                $this->load->model("application_model");
                $this->load->model('customerProducts_model');
                $this->load->helper('url_helper');
                $this->load->view('templates/head');
//                $this->load->view('common/header');

        }
    
         public function index(){
                $this->load->view('customer/customer');
        }
        
        public function view(){
            $data['customers'] = json_decode($this->customer_model->get_customers());  
            $this->load->view('customer/view',$data);
        }

        public function create() {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $data['title'] = 'Create New Customer';

            $this->form_validation->set_rules('nameLast', 'Customer Name', 'required');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('customer/create',$data);
            } else {
                $custData = array(
                    'nameLast' => $this->input->post('nameLast'),
                    //'id' => $this->input->post('id'), // remove
                );
                $customer_id =  $this->customer_model->setCustomer($custData);
                $this->customerProducts_model->customer = $customer_id;
                $this->customerProducts_model->product = 1;
                $inserts = $this->customerProducts_model->safeInsertProducts();
                $inserts = $this->customerProducts_model->safeInsertChecklistAllProducts();

                $data["msg"] = "Customer Added";
                $this->load->view('customer/success',$data);  
            }
        }
        
         public function display(){
                 $this->load->view('customer/display');
        }
        
        public function showtemplate($templateid=null){
            $data['application']= $this->customertemplates_model->get_rendered_template(1,$templateid);
            $this->load->view('customer/applications/application', $data);
        }
        public function showapplication($templateid=null, $custid=null)
        {
            
        	$application_data = $this->customertemplates_model->get_rendered_application($custid,$templateid);
        	//print_r($application_data);
        	
        	 // It is not wise to call model directly on view, so getting data here
        	 
        	
        	/* $template_data =  json_decode($this->customertemplates_model->get_customertemplate_byorig_id($templateid,$custid));
        	
        	 
        	 foreach ($template_data as $template) // result is always 1 row as fetched using id
        	 {
        	 	$template_name = $template->TemplateName;
        	 	
        	 } */
        	
        	 $template_name = "";
        	$application = array();
        	
        	$ctr = 0;
        	
        	foreach ($application_data as $question)
        	{
        		//$application[$question->templatekey] = array();
        		// It is not wise to call model directly on view, so getting data here
        		
        		$template_name = $question->TemplateName;

        	 /* $sec_data = json_decode($this->customersections_model->get_sectionDataByUId($question->sectionKey));
			  $sec_key = "";
			  foreach ($sec_data as $section)  // result is always 1 row as fetched using id
			  {
			  	$sec_key = $section->uid."^^".$section->description;			  	
			  }	*/
        	   
        		$sec_key = $question->sectionKey."^^".$question->sectionname; 
        		
        		$application[$question->templatekey][$sec_key][$ctr++] = $question;        		
        		
        	}
        	
        	$message = "";
        	if($ctr == 0)
        	{
        		$message = "Application has been disabled by admin";
        	}
        	
        	$data['application']=  $application; // $this->customertemplates_model->get_rendered_application($custid,$templateid);
            $data['template_name']=$template_name;
            $data['saved_app'] = 0;
            $data['message']= $message;
            
            
            $this->load->view('customer/applications/application', $data);
        }
        
        
        public function showsavedapplication($application_id,$cust_id)
        {
        
        	$application_data = $this->customertemplates_model->getSavedApplication($application_id);
        	
        	$template_name = "";
        	 
        	
        	// It is not wise to call model directly on view, so getting data here
        
        	 
        	/*$template_data =  json_decode($this->customertemplates_model->get_customertemplate_byorig_id($templateid,$custid));
        	 
        	$template_name = "";
        	foreach ($template_data as $template) // result is always 1 row as fetched using id
        	{
        		$template_name = $template->TemplateName;
        		 
        	}*/
        	 
        	$application = array();
        	 
        	$ctr = 0;
        	
        	//print_r($application_data);
        	 
        	foreach ($application_data as $question)
        	{
        		//$application[$question->templatekey] = array();
        		// It is not wise to call model directly on view, so getting data here
        
        		/*$sec_data = json_decode($this->customersections_model->get_sectionDataByUId($question->sectionKey));
        		$sec_key = "";
        		foreach ($sec_data as $section)  // result is always 1 row as fetched using id
        		{
        			$sec_key = $section->uid."^^".$section->description;
        		} */
        		$template_name = $question->TemplateName;
        		$sec_key = $question->SecID."^^".$question->sectionname;
        		
        		
        		$application[$question->applicationID][$sec_key][$ctr++] = $question;
        
        	}
        	 
        	 
        	 
        	$data['application']=  $application; // $this->customertemplates_model->get_rendered_application($custid,$templateid);
        	$data['template_name']=$template_name;
        	$data['saved_app'] = 1;
        	$data['message'] = "";
        	$this->load->view('customer/applications/application', $data);
        }
   
   
}


