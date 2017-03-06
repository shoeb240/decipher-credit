<?php
class Customersectionquestions_model extends CI_Model {

        public function __construct(){
          $this->load->database();
        }

        public function get_customerquestion($question_uid){
        	$query = $this->db->get_where('customerQuestions',array("uid" => $question_uid));        	        	
        	return json_encode($query->row_array());
        }
        
       public function get_customersection_questions($sec_id, $customerid)
        {
        
        	// need to use join as IN query will not give proper order        	 
        	$this->db->select(' customerQuestions.*');
        	$this->db->select(' csqx.secID, csqx.order, csqx.weighting, csqx.parameterOverride');
        	$this->db->from(' customerQuestions');
        	$this->db->join('customerSectionsQuestionsXref as csqx', ' customerQuestions.custid = csqx.custid and customerQuestions.uid = csqx.objID');
        	$this->db->where("csqx.secID", $sec_id);
        	$this->db->where("csqx.custid", $customerid);
        	$this->db->order_by("csqx.order asc");
        	$query = $this->db->get();
                
        	return json_encode($query->result_array());
        }
        
        public function get_no_customersection_questions($sec_id,$customerid)
        {
        	$query =  $this->db->get_where('questions', "  ID NOT IN (Select cq.id from customerQuestions cq  inner join customerSectionsQuestionsXref csx on cq.uid = csx.objID  where csx.secID = ".$sec_id." and csx.custid = ".$customerid.")");
        	return json_encode($query->result());
        }
        
        public function insert_CustomerSectionObjReference($data)
        {        
            if (empty($data)) {
                return false;
            }
            $this->db->insert_batch('customerSectionsQuestionsXref',$data);
        }
        
        public function updateCustomerSectionObjReference($customerid, $section_id,  $secXrefdata_array)
        {
        	$this->db->trans_start(); // we are going to delete
        	$query =$this->db->delete('customerSectionsQuestionsXref', array("secID"=>$section_id,"custid"=>$customerid));
        	$this->db->insert_batch('customerSectionsQuestionsXref',$secXrefdata_array);
        	$this->db->trans_complete();        
        }
        
        public function insertCustomerQuestions($questionArray, $customer_id, $modified_questions_arr = array(), $attrType = '')
        {
        	if (empty($questionArray)) {
                    return false;
                }
        	$qustion_ids = array();
        	$i=0;
        	$insert_array = array();
                $update_array = array();
        	$ins = 0;
        	
        	foreach ($questionArray as $question)
        	{
        		$qid = 	$question["id"];
                        $modified = false;
                        if ($attrType && !empty($modified_questions_arr)) {
                            $tqid = $attrType . "_" . $qid;
                            if (isset($modified_questions_arr[$tqid])) {
                                $modified_content = urldecode($modified_questions_arr[$tqid]);
                                // Replacing labels in question content
                                preg_match_all("/(<label.*?>.*?<\/label>)/", $question['content'], $original_matches);
                                preg_match_all("/(<label.*?>.*?<\/label>)/", $modified_content, $modified_matches);
                                $question['content'] = str_replace($original_matches[0], $modified_matches[0], $question['content']);
                                $modified = true;
                            }
                        }
                        
        		// Check is question already exits if exists leave it.
        		$qustion_ids[$i] = $qid;
        		$i++;
        		$this->db->where(array("id"=>$qid, "custid"=>$customer_id));
        		$row = $this->db->get("customerQuestions")->row_array();
        		if(!empty($row))
        		{
                            if ($modified) {
                                $question['uid'] = $row['uid'];
                                $update_array[] = $question;
                            }
                            continue; // leave the question as it is;     		
        		}         		    
        		$insert_array[$ins] = $question;
        		$ins++;
        	}
        	 
        	$ids = implode("," , $qustion_ids );
        	//echo $ids;
        	 
        	//$this->db->where(" ID IN ( Select objID from customerSectionsQuestionsXref where custid= ".$customer_id." and secID = ".$custsection_id.") ");
        	
        	// Delete from customerSectionsQuestionsXref first as foreign key contraint is set.
        	
        //	$this->db->where(" objID  IN ( Select uid from customerQuestions where ID IN (".$ids." ) and custid= ".$customer_id." ) and secID = ".$cust_sec_id."  ");
        //	$query =$this->db->delete('customerSectionsQuestionsXref');
        	
        	// Now delete from customerQuestions
        	
        //	$this->db->where(" ID IN (".$ids." )"); 
        //	$this->db->where("custid", $customer_id);
        //	$query =$this->db->delete('customerQuestions');     
                $this->db->trans_start();
                
                if (!empty($update_array)) {
                    $this->db->update_batch('customerQuestions', $update_array, 'uid');
                }
                
        	if(!empty($insert_array)) {
                    $this->db->insert_batch('customerQuestions',$insert_array);   // only inesert new question
        	}
                
        	$this->db->trans_complete();                
                
        	// Return  uids to intert values in xref tables
        	$this->db->where(" ID IN (".$ids." )");
        	$this->db->where("custid", $customer_id);
        	$this->db->select("uid,id");     
        	     	
        	return json_encode($this->db->get("customerQuestions")->result());        	
        	
        }
        
        
        public function insertCustomerQuestions2($questionArray, $customer_id)
        {
        	if (empty($questionArray)) {
                    return false;
                }
                
                $qustion_ids = array();
                $insert_array = array();
                foreach ($questionArray as $question)
        	{
                    $this->db->where(array("id" => $question["id"], "custid" => $customer_id));
                    $row = $this->db->get("customerQuestions")->row_array();
                    if(empty($row))
                    {
                        $insert_array[] = $question;
                    }
                    
                    $qustion_ids[] = $question["id"];
                    
                }
                $ids = implode("," , $qustion_ids );
                
                $this->db->trans_start();
        	if(!empty($insert_array)) {
                    $this->db->insert_batch('customerQuestions', $insert_array);   // only inesert new question
        	}
        	$this->db->trans_complete();                
                
                if (empty($ids)) {
                    return false;
                }
                
        	// Return  uids to intert values in xref tables
        	$this->db->where(" ID IN (".$ids." )");
        	$this->db->where("custid", $customer_id);
        	$this->db->select("uid, id");     
        	return json_encode($this->db->get("customerQuestions")->result());        	
        	
        }
        
        
        public function updateCustomerQuestions($questionArray, $customer_id)
        {        	        	
        	return $this->insertCustomerQuestions($questionArray, $customer_id);         	
        }
        
        public function updateBatchCustomerQuestion($update_array)
        {
            if (!empty($update_array)) {
                $this->db->trans_start();
                $this->db->update_batch('customerQuestions', $update_array, 'uid');
                $this->db->trans_complete();  
            }
        }
        
        public function get_customer_question($cust_question_id){
        	$query = $this->db->get_where('customerQuestions',array("uid" => $cust_question_id));
        	return json_encode($query->result_array());
        }
        
        public function get_customer_section_questiondata($cust_question_id,$sec_id)
        {
        	$this->db->select('customerQuestions.*');
        	$this->db->select('csqx.secID, csqx.order, csqx.weighting, csqx.parameterOverride');
        	$this->db->from(' customerQuestions');
        	$this->db->join('customerSectionsQuestionsXref as csqx', ' customerQuestions.custid = csqx.custid and customerQuestions.uid = csqx.objID');
        	$this->db->where("csqx.objID", $cust_question_id);
        	$this->db->where("csqx.secID", $sec_id);    
        	$this->db->where("customerQuestions.uid", $cust_question_id);
        	//customerQuestions.uid
        	$query = $this->db->get();
        	return json_encode($query->result_array());
        }
        
        public function get_customersection_handlers_by_secid($customer_sec_arr)
        {
            if (empty($customer_sec_arr)) {
                return array();
            }
            
            $this->db->select('Distinct(cq.outputType) as question_handler');
            $this->db->from('customerQuestions cq');
            $this->db->join('customerSectionsQuestionsXref as cx', 'cx.objID = cq.uid');
            $this->db->where_in("cx.secID", $customer_sec_arr);
            $query = $this->db->get();

            $res_arr = $query->result_array();

            $ret_arr = array();
            foreach($res_arr as $each) {
                $ret_arr[] = $each['question_handler'];
            }

            return $ret_arr;
        }
        
}//end model

