<?php

class Formhandler extends Base {

        public function __construct()
        {
                parent::__construct(false);
                $this->load->model('questions_model');
                $this->load->model('handlers_model');
                $this->load->model('application_model');
                $this->load->model('applicationsections_model');
                $this->load->model('applicationtemplatessections_model');
                $this->load->model('customersections_model');
                $this->load->model('customersectionquestions_model');
                $this->load->model('applicationquestions_model');
                $this->load->model('handlers_model');
                $this->load->model('applicationsectionsquestions_model');
                $this->load->model('customertemplatessections_model');



        }


        public function processFormData()
        {

            header('Access-Control-Allow-Origin: *');

        $template_key = $_POST["template_key"];
        $submit_form_type = $_POST["submit_form_type"];
        $saved_app = $_POST["saved_app"];

        $template_name = "";
        $msg = "";
        $workflowstate=1;
        if($submit_form_type == 0)
        {
        	$msg =  "Application submitted successfully. We will get back to you shortly.";
        	$workflowstate = 1;
        }
        else if($submit_form_type == 1)
        {
        	$msg = "Application saved successfully. ";
        	$workflowstate = 2;
        }


        if(isset($_POST["template_name"]))
        {
        	$template_name = $_POST["template_name"];
        }


        $app_id = -1;

        if(isset($_POST["application_id"]))
        {
        	$app_id =  $_POST["application_id"];

        }

        $applicant_id = 1;

        if(isset($_POST["applicant_id"]))
        {
        	$applicant_id =  $_POST["applicant_id"];

        }



      // print_r($_POST);

		$section_id = -1;
        $templatedata[$template_key] = array();

		$sec_index = 0;
		$ctr = 0;


		//$result_array = array_merge($_POST,$_FILES);
		$result_array = $_POST;
		$file_array = $_FILES;
		//print_r($result_array);
		//print_r($file_array);

        foreach ($result_array as $key=>$value)
        {

        	if(strpos($key, "^^") > 0)
        	{
        	   $appdata = explode("^^",$key);


        	   if(count($appdata) == 3)
        	   {
        	   	  $sec_id = $appdata[0];
        	   	  $question_id = $appdata[1];
        	   	  $name = $appdata[2];

        	   	  if($section_id != $sec_id)
        	   	  {
        	   	  	$section_id = $sec_id;
        	   	  	$quest_array = array(); //initialize
        	   	  	$ctr = 0;
        	   	  }



        	   	  	$quest_array[$question_id][$ctr++] =  array($name=>$value);
        	   	    $templatedata[$template_key][$sec_id] =  $quest_array;

        	   }

	        }

        }

        $section_id = -1;
        $ctr = 0;
        foreach ($file_array as $key=>$value)
        {

        	if(strpos($key, "^^") > 0)
        	{
        		$appdata = explode("^^",$key);
        		//print_r($appdata);
        		if(count($appdata) == 3)
        		{
        			$sec_id = $appdata[0];
        			$question_id = $appdata[1];
        			$name = $appdata[2];

        			if($section_id != $sec_id)
        			{
        				$section_id = $sec_id;
        				$quest_array = array(); //initialize
        				$ctr = 0;
        			}



        			$this_question_array = $templatedata[$template_key][$sec_id][$question_id];
                    $file_value = array($name=>$value);
                   

        			if(isset($this_question_array) and count($this_question_array ) > 0)
        			{
        			  $ctr = count($this_question_array);
        			 // $quest_array[$question_id][$ctr++] = $file_value;
        			 // print_r($quest_array);
        			  
        			  //print_r($this_question_array);
        			  //print_r($file_value);


        			  $quest_array = array_push($this_question_array , $file_value);
        			//  print_r($this_question_array);

        			}
        			else
        			{
        				$this_question_array[$question_id][$ctr++]  = $file_value;

        			}

					//print_r($quest_array);

        			$templatedata[$template_key][$sec_id][$question_id] = $this_question_array;
        		}
        	}
        }

       //print_r($templatedata);

          foreach ($templatedata as $key => $val)
          {
          	$template_id = $key;
          	$sec_data = $val;
          	if($saved_app == 0)
          	{
          		
          		if($submit_form_type == 0)
          		{
          		foreach ($sec_data as $sec_key=>$sec_val)
          		{
          			$question_data = $sec_val;


          				$error_array = array(); // This should be JSON obj array;
          				$counter = 0;

          				foreach ($question_data as $question_key => $question_val) // First check  server side validation for handler
          				{
          					$question_id = $question_key;
          					$question_json = json_decode($this->customersectionquestions_model->get_customer_question($question_id));
          					$handler_id = $question_json[0]->outputType;
          					$handler_data = json_decode($this->handlers_model->get_handlerDataById($handler_id));

          					$handler_file_name = $handler_data[0]->handler;

          					$class_name = substr($handler_file_name,0, strlen($handler_file_name) - 4 ) ;// 4 is ext length

          					$handler_obj = new $class_name($question_id); // initialize with customer silo id as we need to only run accept function and not serialize it.

          					$handler_obj->setvalues($question_val);
          					// It should be like
          					//  $accept_obj = $handler_obj->accept();
          					//   if(!$accept_obj->accept)
          					//  {
          					//    $error_array[$counter++] = $accept_obj;
          					//	}
          					//
          					//

 //         					if(!$handler_obj->accept())
 //         					{

 //         						$error_array[$counter++] =  $handler_obj->getResponse()->getResponseText(); // Use the new JSON obj

 //         					}
                                                log_message("DEBUG", "FORMHANLDER CALL ACCEPT $class_name");
                                                $rs=json_decode($handler_obj->accept());
                                                if(!$rs->ok)
                                                {
          			                				$error_array[$counter++] = $rs->reason;
          			                			}

          				}

          				if(count($error_array) > 0)
          				{
          					print_r($error_array);//
          					return ;
          				}

          		}
          	}




          	$this->application_model->startTransaction();
          	$this->application_model->templateID = $template_id;
          	$this->application_model->applicant = $applicant_id;
          	$this->application_model->templateName = $template_name;
          	$this->application_model->createdBy = "";
          	$this->application_model->submittedBy = "";
          	$this->application_model->status = 1;
          	$this->application_model->workflowState = $workflowstate;


          	//if($app_id != -1)
          //	$this->application_model->startTransaction();// db trans

          	// will check with SP first if ApplicationSilo already contains the app. If not then only insert
          	// need to check

          	$application_uid;
          	if(!$saved_app)
          	{
          	$this->application_model->insertApplication();
          	$application_uid = $this->application_model->id;
          	}
          	else
          	{

          		$application_uid = $template_key;
          	}


          	//$sec_data = $val;
          	$sec_ord=1;


          	foreach ($sec_data as $key=>$val)
          	{
          		$sec_id = $key;

          		//$customer_section_data =  json_decode($this->customersections_model->get_sectionDataByUId($sec_id));

          		$customer_section_data =  json_decode($this->customertemplatessections_model->getCustomerTemplateSecXrefbyUID($template_id, $sec_id));
          		//print_r($customer_section_data);


          		$this->applicationsections_model->applicantID = $template_id;//$application_uid;
          		$this->applicationsections_model->id = $sec_id;
          		$this->applicationsections_model->description = $customer_section_data[0]->description;
          		$this->applicationsections_model->status = $customer_section_data[0]->status;
          		$this->applicationsections_model->insertApplicationSection();

          		$application_sec_uid = $this->applicationsections_model->uid;


          		$this->applicationtemplatessections_model->applicationID = $application_uid ; // need to confirm
          		$this->applicationtemplatessections_model->id = $application_sec_uid; // need to confirm
          		$this->applicationtemplatessections_model->templateKey = $template_key;
          		$this->applicationtemplatessections_model->sectionKey = $sec_id ;
          		$this->applicationtemplatessections_model->order = $customer_section_data[0]->order; //$sec_ord++;
          		$this->applicationtemplatessections_model->weighting = $customer_section_data[0]->weighting;

          		$this->applicationtemplatessections_model->insertApplicationTemplateSection(); // AppTempSecXRef;

          		$question_data = $val;
          		$order = 1;

          		foreach ($question_data as $key => $val)
          		{
          			//print_r($question_data);
          			$input_data = $val;

          			$question_id = $key;
          			$question_json = json_decode($this->customersectionquestions_model->get_customer_section_questiondata($question_id,$sec_id));
          			$handler_id = $question_json[0]->outputType;
          			$handler_data = json_decode($this->handlers_model->get_handlerDataById($handler_id));

          			$handler_file_name = $handler_data[0]->handler;

          			$class_name = substr($handler_file_name,0, strlen($handler_file_name) - 4 ) ;// 4 is ext length

          			//echo $class_name;


          			$this->applicationquestions_model->applicationID = $application_uid;
          			$this->applicationquestions_model->id = $question_json[0]->uid;
          			$this->applicationquestions_model->des = $question_json[0]->des;
          			$this->applicationquestions_model->content  = $question_json[0]->content;
          			$this->applicationquestions_model->serialContent = null;
          			$this->applicationquestions_model->outputType = $question_json[0]->outputType;
          			$this->applicationquestions_model->attributes = $question_json[0]->attributes;
          			$this->applicationquestions_model->parameters = $question_json[0]->parameters;
          			$this->applicationquestions_model->status= $question_json[0]->status;
          			$this->applicationquestions_model->insertApplicationQuestion();

          			$application_ques_uid = $this->applicationquestions_model->uuid;


          			$handler_obj = new $class_name($application_ques_uid);

          			// Set the input/file values as a memeber variable of handler

          			//print_r($input_data);
          			//print_r($handler_obj);

          			$handler_obj->setvalues($input_data);

          			
          			if(isset($handler_obj->fileobj))
          			{
          				
          				$this->applicationquestions_model->blobContent = serialize($handler_obj->fileobj);          				
          			}
          			else
          			{
          				$this->applicationquestions_model->blobContent = null;          				
          			}
          				
          			
          			$handler_obj->fileobj = null; // null it before serialContent to be added as it's length is only 4096
          			
          			$this->applicationquestions_model->serialContent = serialize($handler_obj);


          			//print_r(unserialize($this->applicationquestions_model->serialContent));


          			$this->applicationquestions_model->updateApplicationQuestions();

          			$this->applicationsectionsquestions_model->applicationID = $application_uid;
          			$this->applicationsectionsquestions_model->id = $question_json[0]->uid; //$customer_question;
          			$this->applicationsectionsquestions_model->secID = $application_sec_uid;
          			$this->applicationsectionsquestions_model->objID = $application_ques_uid; // need to confirm if original qid or appquest qid
          			$this->applicationsectionsquestions_model->order = $question_json[0]->order;//order++
          			$this->applicationsectionsquestions_model->status = $question_json[0]->status;
          			$this->applicationsectionsquestions_model->weighting =$question_json[0]->weighting;
          			$this->applicationsectionsquestions_model->parameterOverride = $question_json[0]->parameterOverride;
          			$this->applicationsectionsquestions_model->insertApplicationSectionQuestion();

          			if($submit_form_type == 0) // Final Submit
          			{

          				//echo "FORM HANDLER CALL RUNIT $class_name";
                       log_message("DEBUG", "FORM HANDLER CALL RUNIT $class_name");


          				$handler_obj->runit();


          			}
          		}

          		}

          	}

          	else
          	{
          		// Update question table serial content only
          		foreach ($sec_data as $key=>$val)
          		{
          			$question_data = $val;

          			foreach ($question_data as $key => $val)
          			{
          				$input_data = $val;
          				$question_id = $key;
          				
          				
          				$this->applicationquestions_model->getApplicationQuestion($question_id);
          				
          				$handler_id = $this->applicationquestions_model->outputType;
          				$handler_data = json_decode($this->handlers_model->get_handlerDataById($handler_id));
          				
          				$handler_file_name = $handler_data[0]->handler;
          				
          				$class_name = substr($handler_file_name,0, strlen($handler_file_name) - 4 ) ;// 4 is ext length
          							
          				$handler_obj = new $class_name($question_id);
          				
          				
          				$handler_obj->setvalues($input_data);
          				
          				$blobContent = "";
          				$content = "";
          				 
          				if(isset($handler_obj->fileobj))
          				{
          				
          					$this->applicationquestions_model->blobContent = serialize($handler_obj->fileobj);
          				}
          				else
          				{
          					$this->applicationquestions_model->blobContent = null;
          				}
          				
          				 
          				$handler_obj->fileobj = null; // null it before serialContent to be added as it's length is only 4096
          				 
          				$this->applicationquestions_model->serialContent = serialize($handler_obj);
          				
          				$this->applicationquestions_model->updateApplicationQuestions();
          				
          				
          				
          				// udate application silo question here


          			}

          		}

          	}

          	$this->application_model->endTransaction();



          	}

          echo $msg;
         // $this->application_model->endTransaction();

        }

public function downloadFile()
{
	
	$name = $_GET["name"];
	$key = $_GET["id"];
	$this->load->library('utility/fileobj');
	
	if(strpos($key, "^^") > 0)
	{
		$appdata = explode("^^",$key);
		//print_r($appdata);
		if(count($appdata) == 3)
		{
			$sec_id = $appdata[0];
			$question_id = $appdata[1];
			
		  $attachments = $this->applicationquestions_model->getApplicationQuestionAttachment($question_id);
		  
		 // print_r($attachments);
		  
		  foreach ($attachments as $attachment)
		  {	
	
		  	//if(isset($attachment["blobContent"]))
		  	
		  	//$this->load->model('base/basehandler');
		  	$file_obj_ser = $attachment["blobContent"];
		  	//$file_obj = unserialize($file_obj_ser);
		  	//print_r($file_obj->fileName);
		  	
		  	if(isset($file_obj_ser))
		  	{
		  	$file_obj = unserialize($file_obj_ser);
		  	
		  	if(strcasecmp($file_obj->fileName, $name) == 0)
		  	{
		  	//$name = urlencode($name);	
			header("Content-length: $file_obj->size");
			header("Content-type: $file_obj->fileType");
			
			header("Content-Disposition: attachment; filename=\"".$name."\"");
			echo $file_obj->file_content;
		  	}
		  	}  
		  }
		}
	}
	else {
	echo "Attachment Not Found";}
}


}