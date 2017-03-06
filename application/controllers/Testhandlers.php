<?php

class Testhandlers extends Base {

        public function index(){
                $class_name = 'househandler';
                $question_id = 999;
                $val = null;
                
            	$handler_obj = new $class_name($question_id); // initialize with customer silo id as we need to only run accept function and not serialize it.
          	$handler_obj->setvalues($val);
                $rs=json_decode($handler_obj->accept());
                print_r($rs);
          	
        }
        
        
        
        
}