<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Applications_model extends CI_Model {

        public function __construct(){
          $this->load->database();
          $this->load->helper("string");
        }

        public function get_applications($custid) {
            $data = $this->prepare_application_data($custid);
            return json_encode($data);
        }
        
        public function get_application_by_id($custid, $application_id) {
            $data = $this->prepare_application_data($custid, $application_id);
            return json_encode($data);
        }

        public function get_section_questions_by_appid($application_id) {
            
            $this->db->select("as.uid, as.applicantID, as.description, as.status, atsx.weighting, SectionScore(as.uid) as score");
            $this->db->from("applicationSections as");
            $this->db->join("applicationTemplatesSectionsXref atsx", "atsx.id = as.uid");
            $this->db->join("applicationTemplate at", "at.id = atsx.applicationID");
            $this->db->where("at.id", $application_id);
            $query = $this->db->get();
            $setion_arr = $query->result_array();
            
            $section_ret = array();
            foreach($setion_arr as $i => $section) {
                $section_ret[$i]["id"]    = $section['uid'];
                $section_ret[$i]["name"]  = $section['description'];
                $section_ret[$i]["weight"] = $section['weighting'];
                $section_ret[$i]["score"] = $section['score'];
                
                $this->db->select("aq.uuid, aq.des, aq.parameters, aq.score, aq.content, aq.killlevel, aq.status, asqx.weighting, ar.answerblob, qh.description as handler");
                $this->db->from("applicationQuestions aq");
                $this->db->join("applicationSectionQuestionXref asqx", "asqx.objID = aq.uuid");
                $this->db->join("applicationResults ar", "ar.questionID = aq.uuid and ar.dsource = 0 and ar.versionID=0", "left");
                $this->db->join("questionHandlers qh", "qh.id = aq.outputType", "left");
                $this->db->where("asqx.secID", $section['uid']);
                $query = $this->db->get();
                $question_arr = $query->result_array();
                
                $question_ret = array();
                foreach($question_arr as $j => $question) {
                    $question_ret[$j]["id"]    = $question['uuid'];
                    $question_ret[$j]["name"]  = $question['des'];
                    $question_ret[$j]["handler"]   = $question['handler'];
                    $question_ret[$j]["parameters"] = $question['parameters'];
                    $question_ret[$j]["score"] = $question['score'];
                    $question_ret[$j]["weight"] = $question['weighting'];
                    $question_ret[$j]["question"] = $question['content'];
                    $question_ret[$j]["answer"] = $question['answerblob'];
                    $question_ret[$j]["killlevel"] = $question['killlevel'];
                    $question_ret[$j]["status"] = $question['status'];
                }
                
                $section_ret[$i]["questions"]  = $question_ret;
            }
            
            return $section_ret;
        }

        public function get_question_answers($questionId) {
            $this->db->select("ar.uuid, ar.answerDate, ar.dsource,
                                CASE
                                    WHEN ar.dsource = 0
                                    THEN ar.answerblob
                                    ELSE ' '
                                END as answerblob,
                                ar.sourceScore, ar.sourceWeight, coalesce(concat(ax.provider,' ', ax.service), 'customer provided') as source");
            $this->db->from("applicationResults ar");
            $this->db->join("apiservices ax",  "ax.id = ar.dsource", "left");
            $this->db->where("ar.questionID" , $questionId);
            $this->db->where("ar.versionID", 0);
            $query = $this->db->get();
            
            return $query->result_array();
        }
        
        public function get_answerblob($result_id)
        {
            $this->db->select("ar.answerblob");
            $this->db->from("applicationResults ar");
            //$this->db->where("ar.questionID" , $questionId);
            $this->db->where("ar.uuid" , $result_id);
            $this->db->where("ar.versionID", 0);
            $query = $this->db->get();
            
            return $query->row_array();
        }
        

        
        private function prepare_application_data($custid, $application_id = null, $question_id = null) {

            $this->db->select("at.id, at.createdOn, at.applicant, ap.name, at.templateID, ct.TemplateName, at.workflowState, ApplicationScore(at.id) as score, at.status, p.description as product_name");
            $this->db->from("applicationTemplate at");
            $this->db->join("applicant ap", "ap.uuid = at.applicant", "left");
            $this->db->join("customerTemplates ct", "ct.uuid = at.templateID", "left");
            $this->db->join("products p", "p.uuid = at.productID", "left");
            if ($application_id) {
                $this->db->where("at.id", $application_id);
                $this->db->where_in("ct.custid", $custid);
            } else {
                $this->db->where_in("at.templateID", "select uuid from customerTemplates where custid = " . $custid, false);
            }
            if ($question_id) {
                $this->db->join("applicationQuestions aq", "aq.applicationID = at.id");
                $this->db->where("aq.uuid", $question_id);
            }
            $query = $this->db->get();
            $application_arr = $query->result_array();
            
            $application_ret = array();
            foreach($application_arr as $i => $application) {
                $application_ret[$i]["application_id"] = $application['id'];
                $application_ret[$i]["application_date"] = $application['createdOn'];
                $application_ret[$i]["applicant_name"] = $application['name'];
                $application_ret[$i]["template_name"] = $application['TemplateName'];
                $application_ret[$i]["application_state"] = $application['workflowState'];
                $application_ret[$i]["score"] = $application['score'];
                $application_ret[$i]["product_name"] = $application['product_name'];
                $application_ret[$i]["status"] = $application['status'];
            }
            
            return $application_ret;
        }
        
        private function rand_str($length = 15) {
            return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        }
        
        public function get_checklists($application_id)
        {
            $this->db->select("uuid, label, answer");
            $this->db->where("applicationID", $application_id);
            $this->db->order_by("sorder");
            $query = $this->db->get('applicationProductChecklist');
            
            return $query->result_array();            
        }
        
        public function updateKilllevel($killlevel, $qid)
        {
            $data = array(
                'killlevel' => $killlevel
            );
            
            $this->db->where('uuid', $qid);
            return $this->db->update('applicationQuestions', $data);
        }
 
}
