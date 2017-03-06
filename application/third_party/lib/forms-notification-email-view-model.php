<?php

	
    class NotificationEmailViewModel
    {
        public $FormName;       
		public $Entries;        
		public $Email;
        
		public function __construct()
        {
            $this->Entries = array();
        }
    }
?>