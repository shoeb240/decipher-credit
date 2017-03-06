<?php

	if(!class_exists("Utils"))require_once(ABSPATH . '/lib/forms-utils.php');
    class AddressViewModel
    {
        public $Id;        
        public $Address1;        
        public $Address2;
        public $City;
        public $State;        
        public $ZipCode;
        public $Country;
        public $Longitude;
        public $Latitude;
		
		public function __construct()
		{
		
		}
		
		public static function createFromObject($object)
		{
		  $model = new AddressViewmodel();
		  $model->Id = $object->Id;
		  $model->Address1 = $object->Address1;
		  $model->Address2 = $object->Address2;
		  $model->City = $object->City;
		  $model->State = $object->State;
		  $model->ZipCode = $object->ZipCode;
		  $model->Country = $object->Country;
		  $model->Longitude = $object->Longitude;
		  $model->Latitude = $object->Latitude;
		  
		  return $model;
		}
		
        public static function initialize()
        {
            return new AddressViewModel();
        }
		
		public function format()
        {
            $sb = "";
            $sb .= Utils::strFormat("{0},", $this->Address1);

            if (!empty($this->Address2))
            {
                $sb .= Utils::strFormat(" {0},", $this->Address2);
            }

            $sb .= Utils::strFormat(" {0}, ", $this->City);
            $sb .= Utils::strFormat(" {0}", $this->Country);

            return $sb;
        }
    }
?>