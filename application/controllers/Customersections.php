<?php
class Customersections extends Base {
	private $customer_id;

        public function __construct(){
                parent::__construct();
                $this->load->model('ion_auth_model');
                
                if (!$this->ion_auth->logged_in()){
                	redirect('auth/login');
                }
                
               // $this->user_id = $this->ion_auth->get_user_id();
                $this->load->model('sections_model');
                $this->load->model('customer_model');
                $this->load->model('sectionsquestions_model');
                $this->load->model('questions_model');
                $this->load->model('customersections_model');
                $this->load->model('customersectionquestions_model');
                
                $this->load->helper('url_helper');
                $this->load->view('templates/head');
               
                $this->customer_id =  $this->customer_model->get_customerid_fromuserid($this->ion_auth->get_user_id());
        }

        public function index(){
                $data['sections'] = $this->sections_model->get_sections();               
		$this->template->load('default', 'content', $data);
        }

        public function view(){
                //$data['sections'] = $this->customersections_model->get_customersections($this->customer_id);
                $data['sections'] = $this->customersections_model->get_decipher_sections($this->customer_id);
                $data['sections_questions'] = $this->customersections_model->get_customersections_questions($this->customer_id);
                $this->load->view('customer/customer_sectionview', $data);
        }

        public function create(){ 
                $question_ids = null;
                $this->load->helper('form');
                $this->load->library('form_validation');
                $data['title'] = 'Create a section item';
                $this->form_validation->set_rules('description', 'description', 'required');
                $this->form_validation->set_rules('qid_list', 'qid_list', 'required');
                if ($this->form_validation->run() === FALSE){
                	$data['questions'] = $this->questions_model->get_questions();
                        $this->load->view('customer/customer_sectioncreate',$data);
                 }else{
                    $sec_data = array(
    			'description' => $this->input->post('description'),
    			'status' => 1,
                        'owner' =>  $this->customer_id,
                        'visibility' =>0,		
    			'id' => null);
                    $section_id =  $this->sections_model->set_section($sec_data);
//                    $question_ids = $this->input->post('qid_list');          
         	    $nvps = $this->input->post('qid_list');
                    $jsondata = json_decode($nvps);
                    foreach($jsondata as $myitem){
                      if($question_ids == null){
                        $question_ids = $myitem->qid;   
                      }else {
                       $question_ids = "$question_ids,  $myitem->qid";
                      }
                     }
                     $question_ids = "$question_ids,";

                    $customersec_data = array(
        		'custid' =>  $this->customer_id,
        		'description' => $this->input->post('description'),
       	        	'status' => 1,       		
       		         'id' =>$section_id,
       		         'uid'=>null );
                    $custsection_id =  $this->customersections_model->set_customersection($customersec_data);
                    $insert_array = $this->get_customer_questions_data($question_ids, $this->customer_id);
                    $interted_questions =  $this->customersectionquestions_model->insertCustomerQuestions($insert_array,$this->customer_id);
   
                    $insert_array = $this->get_customer_section_xrefdatawithweight($interted_questions, $custsection_id, $jsondata);
       
                    if(count($insert_array) > 0){
                       $this->customersectionquestions_model->insert_CustomerSectionObjReference($insert_array);
                    }
                     $data["msg"] = "Section Added.";
		     $this->load->view('sections/success',$data);
    }
}

public function edit($custsection_id){
	$question_ids = null;
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$this->form_validation->set_rules('description', 'description', 'required');
	$this->form_validation->set_rules('qid_list', 'qid_list', 'required');
	 
	if ($this->form_validation->run() === FALSE)
	{	
	$data["section_questions"] = json_decode($this->customersectionquestions_model->get_customersection_questions($custsection_id,$this->customer_id));
	$data["remaining_questions"] = json_decode($this->customersectionquestions_model->get_no_customersection_questions($custsection_id,$this->customer_id));
	$data["sec_data"] = json_decode($this->customersections_model->get_customersectionData($this->customer_id, $custsection_id));
	$this->load->view('customer/customer_sectionedit',$data);
        }else{	
		$update_data = array(				
				'description' => $this->input->post('description'),
				'status' => $this->input->post('status')
				
		);
		
		$this->customersections_model->update_section($update_data,$custsection_id);
		$sec_data = json_decode($this->customersections_model->get_customersectionData($this->customer_id, $custsection_id));
		$section_id = $sec_data[0]->id; // Original Section ID
		$this->sections_model->update_section($update_data,$section_id);
//		$question_ids = $this->input->post('qid_list');
		$nvps = $this->input->post('qid_list');
                
                $jsondata = json_decode($nvps);
                foreach($jsondata as $myitem){
              //      log_message("DEBUG", "$myitem->qid");
              //      log_message("DEBUG", "$myitem->weight");
                    if($question_ids == null){
                     $question_ids = $myitem->qid;   
                    }else {
                    $question_ids = "$question_ids,  $myitem->qid";
                    }
                }
                $question_ids = "$question_ids,";
                $insert_array = $this->get_customer_questions_data($question_ids, $this->customer_id);
 	        $updated_questions = $this->customersectionquestions_model->updateCustomerQuestions($insert_array,$this->customer_id);
		 
$update_array = $this->get_customer_section_xrefdatawithweight($updated_questions,$custsection_id,$jsondata);
		
                if(count($update_array) > 0){
		$this->customersectionquestions_model->updateCustomerSectionObjReference($this->customer_id,$custsection_id,$update_array);
                }
		
		$data["msg"] = "Section Updated.";
		$this->load->view('sections/success',$data);
		
	}	
	
}

private function get_customer_questions_data($question_ids, $customerid)
{	
	$question_ids = substr($question_ids, 0, strlen($question_ids)-1 ); // remove extra commma from end				
	$question_id_array = explode(",", $question_ids);		
	$insert_array = array();
	$i=0;
		
	for($i=0; $i< sizeof($question_id_array) ;$i++ )
	{
		$values = array();
		$question_id = $question_id_array[$i];
		$question_data = json_decode($this->questions_model->get_question($question_id_array[$i]));
		
		/*
		echo "<pre>";
		print_r($question_data);
		echo "</pre>"; */
		
		 $values["custid"] = $customerid;		 		 
		 $values["id"] = $question_id;
		 $values["des"] = $question_data[0]->des;
		
		 $values["type"] =$question_data[0]->type;
		 $values["weight"]= $question_data[0]->weight;
		 $values["content"] = $question_data[0]->content;
		 $values["outputType"] = $question_data[0]->outputType;
		 $status = $question_data[0]->status;
		 	
		 $values["status"] = $status;
		 $attributes =  $question_data[0]->attributes;
		 $values["attributes"] = $attributes;
		 
		 $values["parameters"] = $question_data[0]->parameters;
	 	$insert_array[$i] = $values;
	}
	
	return $insert_array;
}


private function get_customer_section_xrefdata($new_questions,$customer_sectionid,$question_ids)
{
	
	$new_questions = json_decode($new_questions);
	
	$question_ids = substr($question_ids, 0, strlen($question_ids)-1 ); // remove extra commma from end
	$question_id_array = explode(",", $question_ids);
	
	$insert_array = array();
	$i=0;
	
	//for($i=0; $i< sizeof($question_id_array) ;$i++ )
	foreach ($new_questions as $question)
	{
		$values = array();
		$values["custid"] = $this->customer_id	;
		$values["objID"] = $question->uid;
		$values["secID"] = $customer_sectionid;
		$values["order"] =   array_search($question->id, $question_id_array) +1; //$i +1; Order should be maintaned as per user inserted 
		$values["status"]= 1;
		$insert_array[$i] = $values;
		$i++;
	}
	
	return $insert_array;
	
}

private function get_customer_section_xrefdatawithweight($new_questions,$customer_sectionid, $jray)
{
	$new_questions = json_decode($new_questions);
	$question_id_array = array();
	$weight_id_array = array();
        foreach($jray as $nvp){
            $rs = array_push($question_id_array, $nvp->qid);
            $rs = array_push($weight_id_array, $nvp->weight);
        }
	$insert_array = array();
	$i=0;
	foreach ($new_questions as $question)
	{
		$values = array();
		$values["custid"] = $this->customer_id	;
		$values["objID"] = $question->uid;
		$values["secID"] = $customer_sectionid;
		$values["order"] =   array_search($question->id, $question_id_array) +1; 
		$values["status"]= 1;
		$values["weighting"]= $weight_id_array[$values["order"]-1];
		$insert_array[$i] = $values;
		$i++;
	}
	
	return $insert_array;
	
}




private function get_questions_data($question_ids,$section_id)
{

	$question_ids = substr($question_ids, 0, strlen($question_ids)-1 ); // remove extra commma from end


	$question_id_array = explode(",", $question_ids);

	$insert_array = array();
	$i=0;

	for($i=0; $i< sizeof($question_id_array) ;$i++ )
	{
		$values = array();
		$values["objID"] = $question_id_array[$i];
		$values["secID"] = $section_id;
		$values["order"] = $i +1;
		$values["status"]= 1;
		$insert_array[$i] = $values;
	}

	return $insert_array;
}
 
}
