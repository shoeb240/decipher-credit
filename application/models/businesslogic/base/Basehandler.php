<?php

abstract class Basehandler extends CI_Model 
{
        protected $id; // applicaitonQuestions uid;
        protected $score; 
        protected $questionParams;
        protected $questionData;
        public $fileobj = null;
        
       
        
        
       abstract function setvalues($question_data);
       abstract function getValues();
       abstract function calculatescore();
       abstract function load_api_data();
       abstract function accept();
       // accept must return a structure like this
       //       $response = new stdClass();
       //     $response->reason="User Explain for fail only required on false";
       //     $response->fname="field name of item only required on false";
       //     $response->ok= true or false;
       //     return json_encode($response);

       public final function baseSetValues($question_data){
           $this->questionData = $question_data;
           $this->setvalues($question_data);
           
       }
       private final function myanswer(){
            return serialize($this->questionData);
       }

        public function __construct($id){
        	$this->id = $id;
                $this->load->database('');
        }
       
       private final function loadparams(){
           $this->db->select('parameters');
           $query = $this->db->get_where('applicationQuestions', array('uuid' => $this->id));
           $res = $query->result_array();
           return $res;
           
       }
       public final function runit(){
            $this->questionParams = $this->loadparams();           
            $this->savebaseanswer();
            $this->load_api_data();            
            $this->setScore($this->calculatescore());            
            $this->savescore();
                   
       }
       private final function setScore($score){
           $this->score=$score;
       }
       
       private final function savescore(){
        $this->db->set('score', $this->score);
      	$this->db->where('uuid', $this->id);
      	$rs = $this->db->update('applicationQuestions');
        return $rs;
       }// end savescore
       
       private final function savebaseanswer(){
        $this->db->set('answerblob', $this->myanswer());
        $this->db->set('questionID', $this->id);
        $this->db->set('dsource', 0);
  	$rs = $this->db->insert('applicationResults');
        return $rs;
       }
       public final function rerunit(){
           
       }
       public final function rescore(){
            $this->setScore($this->calculatescore());
            $this->savescore();
           
           
       }
       
       function setFileObj($fileName,$tmpName, $size, $fileType)
       {
       	$this->load->library('utility/fileobj');
       	$this->fileobj =  new Fileobj();
       	$this->fileobj->setValues($fileName,$tmpName, $size, $fileType);
       
       }
}
 


 /*class Fileobj
 {
 
 	public $fileName;
 	public $tmpName;
 	public $size;
 	public $fileType;
 	public $file_content;
 
 	public function __construct($fileName,$tmpName, $size, $fileType)
 	{
 
 		$this->fileName = $fileName;
 		$this->tmpName = $tmpName;
 		$this->size = $size;
 		$this->fileType = $fileType;
 		
 		//print_r($tmpName);
 		
 		$fp      = fopen($tmpName, 'r');
 		$content = fread($fp, filesize($tmpName));
 		$this->file_content  = addslashes($content);
 		fclose($fp);
 		
 	}
 	
 }*/
 