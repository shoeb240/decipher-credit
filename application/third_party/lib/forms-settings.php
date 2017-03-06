<?php 


	class Settings
	{
	   /***************************************/
	   /* Database settings                   */
	   /* (Required for the aplication to run */
	   /***************************************/
	   
	  
	   
	   // Demo only
	   // Database host-name
	   const HOST ="edsmysqlinstance.cswmtlrbjlrc.us-east-1.rds.amazonaws.com";    
	   
	   // The name of the form-builder database 
	   const DB_NAME="creditv02";
	   
	   // Thee username of the database
	   const DB_USERNAME="root";
	   
	   //The password for the database
	   const DB_PASSWORD="decipher1!";
	   
	   /***********************/
	   /*File Upload settings */
	   /***********************/
	   
	   // The location to save files on disk
	   const FILE_SAVE_PATH=  "uploads/";
	   
	   // The file extensions you want to support by default for the upload feature
	   const DEFAULT_FILE_EXTENSIONS=".jpg,.png,.gif,.pdf,.bmp,.zip";
	   
	   // The default maximum file size you want to support for file uploads
	   const DEFAULT_MAX_FILE_SIZE_IN_KB="5000";
	   
	   // The default minimum file size you want to support for file uploads
	   const DEFAULT_MIN_FILE_SIZE_IN_KB="10";
	   	   
	   
	   /***********************/
	   /*Amazon cloud settings*/
	   /***********************/
	   
	   // Set to true to upload files to amazon cloud, set to false to store files in local storage
	   const USE_CLOUD_STORAGE=false;
	   
	    // Amazon S3 access key
	   const AWS_ACCESS_KEY="";
	   
	   // Amazon S3 secret key
	   const AWS_SECRET_KEY="";
	   
	   // Amazon S3 bucket to store files
	   const AWS_BUCKET="";	
	   
	   
	   /***********************/
	   /*Emailer settings     */
	   /***********************/
	   
	   // Set to true to enable notifications when forms are submitted
	   const ENABLE_NOTIFICATION=false;
	   
	   // Sender email to use when sending notifications
	   const SENDER_EMAIL="";
	   
	   // Sender name to use when sending notifications
	   const SENDER_NAME="";
	   
	   // Email host to use when sending notifications
	   const EMAIL_HOST="";
	   
	   // Email port to use when sending notifications
	   const EMAIL_PORT=25;
	   
	   // Email password to use when sending notifications
	   const EMAIL_PASSWORD="";
	   
	   // Email username to use when sending notifications
	   const EMAIL_USERNAME="";
	   
	   // Set to true to enable ssl when sending notifications else set to false
	   const EMAIL_ENABLE_SSL=false;
	   
	   
	   /****************************************************/
	   /*Recaptcha settings                                */
	   /* Get a key here: https://www.google.com/recaptcha */
	   /****************************************************/	   
	   const RECAPTCHA_KEY="";
	
	   const RECAPTCHA_SECRET="";
	
	   const RECAPTCHA_LANG="en";
	
	   const RECAPTCHA_THEME="white";   
	   
	   // works with x_debug to allow debugging. 
	   const DEBUG=false;
	   
	   const LOCKED_FORM_IDS="";
	   
	   const SHOW_TEMPLATES_IN_LIST=false;
	   
	   const DEFAULT_TEMPLATES_PATH="/template-files";
	   
	   const SHOW_UPDATE_TEMPLATES_BUTTON=true;
	   
	}

?>