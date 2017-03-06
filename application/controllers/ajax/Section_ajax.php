<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Section_ajax extends CI_Controller {
	
	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('ion_auth_model');
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login');
		}
		$this->load->model('sectionsquestions_model');	
		$this->load->model('customer_model');
		$this->load->model('questions_model');		
		$this->load->model('customersectionquestions_model');
		
	}
	
	
	public function GetCustomerSectionContent()
	{
		
		$custid =  $this->customer_model->get_customerid_fromuserid($this->ion_auth->get_user_id());
		
		
		if(isset($_POST['section_id']) && $custid !="")
		{
			$sec_id_array = array();
		
			$section_id = $_POST['section_id'];
		
			if (strpos($section_id, "^") !== false )
			{
				$sec_id_array = explode("^", $section_id)  ;
			}
		
			if(count($sec_id_array) == 0)
			{
				$sec_id_array[0] = $section_id;
			}
			
			$all_questions_html =  "";
			foreach ($sec_id_array as $sec_id)
			{
                                $questions = '';
                                $questionIndp = '';
				if($sec_id != '')
				{
                                    $sec_details = array();
                                    if (strpos($sec_id, '~') !== false) {
                                        $ques_id_arr = explode('~', substr($sec_id, 0, strlen($sec_id) - 1));
                                        foreach ($ques_id_arr as $ques_id) {
                                            $ques_details = explode("|", $ques_id);

                                            $questionIndp = json_decode($this->questions_model->get_question($ques_details[0]));
                                            if(!empty($questionIndp))
                                            {
                                                    $question_content =   $questionIndp[0]->{'content'};  //json_decode($this->questions_model->get_question($question->objID));

                                                    $all_questions_html .=  "<div name='outer' onclick=\"javascript: showQuestionAttribute('".$questionIndp[0]->{'id'}."', 'indp');\" class = 'outer' id = '".$questionIndp[0]->{'id'}."' value='".$questionIndp[0]->{'id'}."'  >" .  $question_content . "</div>";
                                            }
                                        }
                                    } else if (substr($sec_id, 0, 2) == "!#") {
                                        $sec_id = substr($sec_id, 2);
					$sec_details = explode("|",$sec_id);
                                        
                                        $questionsDeci = json_decode($this->sectionsquestions_model->get_section_questions($sec_details[0]));
                                        if (!empty($questionsDeci)) {
                                            $all_questions_html .= "<div name='section' class='section'><h4 class='section-title'>".$sec_details[1]." </h4> ";
                                            foreach ($questionsDeci as $question)
                                            {
                                                    $question_content =   $question->content;

                                                    $all_questions_html .=  "<div name='outer' onclick=\"javascript: showQuestionAttribute('".$question->id."', 'deci');\" class = 'outer' id = 'deci_".$question->id."' value='".$question->id."'  >" .  $question_content . "</div>";
                                            }
                                            $all_questions_html .= "</div>"; // end section
                                        }
                                        
                                    } else {
					$sec_details = explode("|",$sec_id);
                                        
					$questionsCust = json_decode($this->customersectionquestions_model->get_customersection_questions($sec_details[0] ,$custid));
                                        if (!empty($questionsCust)) {
                                            $all_questions_html .= "<div name='section' class='section'><h4 class='section-title'>".$sec_details[1]." </h4> ";
                                            foreach ($questionsCust as $question)
                                            {
                                                    $question_content =   $question->content;

                                                    $all_questions_html .=  "<div name='outer' onclick=\"javascript: showQuestionAttribute('".$question->uid."', 'cust');\" class = 'outer' id = 'cust_".$question->uid."' value='".$question->id."'  >" .  $question_content . "</div>";
                                            }
                                            $all_questions_html .= "</div>"; // end section
                                        }
                                    }
                                    
                                     
				}
			} 
			echo $all_questions_html;
		}
	}
		

		
		
	
	
	public function GetSectionContent()
	{
		if(isset($_POST['section_id']))
		{
		$sec_id_array = array();
		
		$section_id = $_POST['section_id'];
		
	    if (strpos($section_id, "^") > 0 ) 
	    {
	    	 $sec_id_array = explode("^", $section_id)  ;
	    }
		
	    if(count($sec_id_array) == 0)
	    {
	    	$sec_id_array[0] = $section_id;	    	
	    }
	    $all_questions_html = "";
	    foreach ($sec_id_array as $sec_id)
	    {
		if($sec_id != '')
		{
                    $sec_details = array();
                    $sec_details = explode("|",$sec_id);
			
			
                    $questions = json_decode($this->sectionsquestions_model->get_section_questions($sec_details[0]));

                    if(count($questions)> 0)
                    {
                        $all_questions_html .= "<div name='section' class='section'><h4 class='section-title'>".$sec_details[1]." </h4> ";
                        foreach ($questions as $question)
                        {
                            $question_content =   $question->content; 

                            $all_questions_html .=  "<div name='outer' onclick=\"javascript: showQuestionAttribute('".$question->id."', 'deci');\" class = 'outer' id = 'deci_".$question->id."' value='".$question->id."'  >" .  $question_content . "</div>";			
                        }
                        $all_questions_html .= "</div>"; // end section
                    }

	
		
		}
	    }
	    echo $all_questions_html;
	  }
		
	}
	
    public function CopyDecipherSection()
    {
        $customer_id = $this->input->post('customer_id');
        $section_id = $this->input->post('section_id');
        
        $this->load->model('sections_model');	
        $section_data =  json_decode($this->sections_model->get_sectionDataById($section_id));
        
        if ($customer_id < 0)
        {
            echo json_encode(array('response' => 'failed'));
            return false;
        }
        
        // customerTemplate
        $this->db->where(array("id" => $section_id, "custid" => $customer_id));
        $row = $this->db->get("customerSections")->row_array();
        if(empty($row))
        {
            $section_data = array(
                'uid' => null,
                'custid' => $customer_id,
                'id' => $section_id,
                'description' => $section_data->description,
                'status' => $section_data->status
            );
            $custsection_id =  $this->customersections_model->set_customersection($section_data);
            
            $result = "created";
        }
        else 
        {
            $custsection_id = $row['uid'];
            
            $result = "duplicate";
        }

        // customerSections
//        $orig_section_id_array = json_decode($this->sections_model->get_decipher_sections_by_template_id($section_id));
//        $tmp_sec_insert_array = array();
//        $sectionOrder = 0;
        //foreach($orig_section_id_array as $eachDecipherSection) {

            //$origSection = $eachDecipherSection;
            //$orig_section_id = $eachDecipherSection->id;
            //$orig_section_order = $eachDecipherSection->order;

            //$this->db->where(array("id" => $orig_section_id, "custid" => $customer_id));
            //$row = $this->db->get("customerSections")->row_array();
            /*if(!empty($row))
            {
                $custsection_id = $row['uid'];
            } 
            else 
            {
                // Create customer section copied from decipher section
                $customersec_data = array(
                    'uid' => null,
                    'custid' =>  $customer_id,
                    'id' => $orig_section_id,
                    'description' => $origSection->description,
                    'status' => 1,       		
                );
                $custsection_id =  $this->customersections_model->set_customersection($customersec_data);
            }*/
            
            // customerQuestions
            $original_ques_arr = json_decode($this->sectionsquestions_model->get_section_questions($section_id));
            $insert_array = $this->prepare_customer_questions_data($original_ques_arr, $customer_id);
            $interted_questions =  json_decode($this->customersectionquestions_model->insertCustomerQuestions2($insert_array, $customer_id));
            
            // customerSectionsQuestionsXref
            $insert_array = $this->prepare_customer_section_question_xref_data($interted_questions, $custsection_id, $customer_id);
            if(count($insert_array) > 0) {
                $this->customersectionquestions_model->insert_CustomerSectionObjReference($insert_array);
            }

            // customerTemplatesSectionsXref
            /*$tmp_sec_insert = $this->prepare_customer_template_section_xref_data($customer_section_id, $custsection_id, $customer_id, $orig_section_order);
            if (!empty($tmp_sec_insert))
            {
                $tmp_sec_insert_array[] = $tmp_sec_insert;
            }*/
        //}
        
        // customerTemplatesSectionsXref
        //$this->customertemplatessections_model->insert_custTemplateSecReference($tmp_sec_insert_array);
        
        echo json_encode(array('response' => $result));
        
    }
    
}
	