<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Base {

     public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->view('templates/head');
        }
	 public function index(){
          	
        }
}
