<?php

class Base extends CI_Controller {
        public $myacl;
        public function __construct($loadmenu = true)
        {
                parent::__construct();
                $acl = null;
                if (!$this->ion_auth->logged_in()){
                    $acl = 0;
                } else if ($this->ion_auth->is_admin()) {
                    $acl = 1;
                } else{
                    $acl = 2;
                }
                $this->myacl = $acl;
                if($loadmenu)
                {
                $data['menulist']= $this->menulist_model->get_menus($acl);
                $this->load->view('common/head', $data);
                if ($this->uri->segment(1) !== 'widget') {
                    $this->load->view('common/header_1', $data);
                }
                }

        }

}