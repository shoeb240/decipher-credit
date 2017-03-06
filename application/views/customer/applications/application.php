<?php
$csslink = base_url() . "/public/customerversion.css";
$this->load->library('utility/fileobj');
?>
<script type="text/javascript">

if (typeof jQuery !== 'undefined') {
    // Submit Type 0 Final Submit, 1 save for later review, 2, partial save
    function submitF(submitType) {

        $('#submit_form_type').val(submitType);
        var formData = new FormData($("form#data")[0]);


        $.ajax({
            url: '<?php echo base_url() . $this->config->item('index_page') . '/Formhandler/processFormData'; ?>',
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {

                alert(data)
                // need to redirect after showing proper message

            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;

    }

    $('head').append('<link rel="stylesheet" href="<?php echo $csslink; ?>" >');
}

</script>


<form id="data" method="post" enctype="multipart/form-data" >




<div class="container">
 <div class="panel panel-primary">

<?php
echo '<input type = "hidden" name = "submit_form_type" id= "submit_form_type" />';
echo '<input type = "hidden" name = "applicant_id" id= "applicant_id" value = "1" />'; // For now keep it one just for testing purpose. We will be needing dynamic applicant_id here

if(strlen($message) > 0)
{

	echo '<div class="panel-heading "><h4>'.$message.' </h4>';
}


foreach ($application as $key=>$value) // Preare tab headers
{
	$template_key = $key;
	echo '<div class="panel-heading "><h4>Application Form: '.$template_name.' </h4></div>';

	echo '<input type = "hidden" name = "template_key" value = "'.$template_key .'"  />';
	echo '<input type = "hidden" name = "saved_app" value = "'.$saved_app .'"  />';
	echo '<input type = "hidden" name = "template_name" value = "'.$template_name .'"  />';

	echo '<ul id="tabs" class="nav nav-pills nav-stacked col-md-3" data-tabs="tabs">';

	$sectionID = -1;

	$section_data = $value;
	$sec_count = 1;

	foreach ($section_data as $key=>$value)
	{
        $section_nameid = explode("^^",$key);
		$section_key = $section_nameid[0];
		if($sec_count == 1)// first section
		{
			echo '<li class="active"><a href="#'.$section_key .'" data-toggle="tab">'.$section_nameid[1].'</a></li>';

		}
		else
		{

			echo '<li><a href="#'.$section_key .'" data-toggle="tab">'.$section_nameid[1].'</a></li>';
		}

		//$question = $value;
		$sec_count++;

	}
	echo '</ul>';

}

$savedvaluearray = array();
$save_filearray = array();

foreach ($application as $key=>$value) // Preare tab content
{
	$template_key = $key;

	echo '<div id="my-tab-content " class="tab-content well   col-md-9">';

	$sectionID = -1;

	$section_data = $value;
	$sec_count = 1;


	foreach ($section_data as $key=>$value)
	{

		$section_nameid = explode("^^",$key);
		$section_key = $section_nameid[0];


		$question_data = $value;
		if($sec_count == 1)// first section
		{
			echo '<div class="tab-pane active" id="'.$section_key.'">';
			echo '<h4 class= "well alert-danger">Section: '.$section_nameid[1].' </h4>';
	 			foreach ($question_data as $key=> $value)
	 			{
	 				$question = $value;
	 				$qid = "";

	 				if(isset($question->uid))
	 				{
	 					$qid = $question->uid;

	 				}
	 				else
	 				{
	 					$qid = $question->uuid;

	 				}

					$replace_string = "name=\"$section_key^^$qid^^";
					$toreplace_array = array('name="', 'name ="', 'name = "','name= "');
					$question_content = str_ireplace($toreplace_array, $replace_string, $question->content);


					if(isset($question->serialContent) )
					{
						$serialContent = $question->serialContent;

						$originalHandler = unserialize($serialContent);

						//print_r($originalHandler);

						//$values =  get_object_vars(getValues);
						 $values = $originalHandler->getValues();
						//print_r($values);


						if($values != null)
						{
							foreach($values as $key=>$value)
							{
								$namekey = $section_key."^^".$qid."^^".$key;
								$savedvaluearray[$namekey] = $value;
							}


						}
						
						if(isset($question->blobContent))
						{
							$fileObj = unserialize($question->blobContent);
							//print_r($fileObj);
							
						}
					}


					echo $question_content;

	 			}
	 		echo '</div>';

		}
		else
		{
			echo '<div class="tab-pane" id="'.$section_key.'">';
			echo '<h4 class= "alert-danger well">Section: '.$section_nameid[1].' </h4>';



			foreach ($question_data as $key=> $value)
			{

				$question = $value;
				$qid = "";
				if(isset($question->uid))
	 				{
	 					$qid = $question->uid;

	 				}
	 				else
	 				{
	 					$qid = $question->uuid;

	 				}

					$replace_string = "name=\"$section_key^^$qid^^";
					$toreplace_array = array('name="', 'name ="', 'name = "','name= "');
					$question_content = str_ireplace($toreplace_array, $replace_string, $question->content);

					if(isset($question->serialContent) )
					{
					$serialContent = $question->serialContent;

					$originalHandler = unserialize($serialContent);

					//print_r($originalHandler);
					 $values = $originalHandler->getValues();
					//	print_r($values);

					if($values != null)
					{
						foreach($values as $key=>$value)
						{
							$namekey = $section_key."^^".$qid."^^".$key;
							
							
							if(isset($question->blobContent))
							{
							 // print_r($value);	
							  if(is_array($value) && isset($value["name"]))
							  {
							  	$fileObj = unserialize($question->blobContent);							  	
							  	if(strcasecmp($fileObj->fileName, $value["name"]) == 0)
							  	{
							  		//print_r($fileObj);
							  		$save_filearray[$namekey] = $fileObj;
							  		$savedvaluearray[$namekey] = "file"; // reset it as we have value in the file array
							  	}
							  	
							  }
							  
							 
							 
							 	
							}
							
							
						}


					}
					
					
					
					}
				echo $question_content;
			}
			echo '</div>';

		}

		//$question = $value;
		$sec_count++;

	}

	//print_r($savedvaluearray);
	// we will be needing a processing / saving gif here

	echo '<button data-mode="0" onclick="return (typeof window.submitF !== \'undefined\' ? submitF(0) : false);" class="btn btn-success pull-right" >Submit</button>
	<button data-mode="1" onclick="return (typeof window.submitF !== \'undefined\' ? submitF(1) : false);" class="btn btn-success pull-right" >Save as Draft</button>';
	echo '</div>';


}

?>


</div>
</div>

</form>

<script type="text/javascript">


if (typeof jQuery !== 'undefined') {
    $(document).ready(function () {


        <?php
        foreach ($savedvaluearray as $inputname => $inputvalue )
        {
        	
        //print_r($inputvalue);	
        if (is_array($inputvalue)) {
        	
            $inputname = $inputname . "[]";            

        }

        ?>
       

        element = $('[name="<?php echo $inputname ?>"]');

        //console.log(element.is());
        if (element.is("select")) {
            element.val('<?php echo $inputvalue ?>');
        }

        else if (element.is("input")) 
            {
            var type = element.attr("type");
            //alert(type);
            //console.log(type);

            if ((type == "checkbox")) {

                jsArray = <?php echo json_encode($inputvalue) ?>;
                element.each(function () {

                    if (jsArray.indexOf(this.value) != -1) {
                        this.checked = true;
                    }
                    else {
                        this.checked = false;
                    }


                })

            }
            else if (type == "radio") {
                element.filter('[value="<?php echo $inputvalue ?>"]').attr('checked', true);
            }

            else if (type == "text" || type == "date") {
                element.val('<?php echo $inputvalue ?>');
            }

            else if (type == "file")
            {
               
          	  <?php
      		        foreach ($save_filearray as $file_key => $file_obj )
      		        {
      		        	
      		        	if(strcasecmp($file_key, $inputname) == 0)
      		        	{
      		        		$file_content = $file_obj->file_content;
      		        		$filesize = $file_obj->size;
      		        		$filename = $file_obj->fileName;
      		        		$filetype = $file_obj->fileType;
      		        		$url = site_url()."/Formhandler/downloadFile";
      		        		
      		        		
      		        		echo '

      		        		var filename ="'. $filename .'";
      		        		var filesize ="'. $filesize .'";
      		        		var anchor = document.createElement("a");
      		        		anchor.setAttribute("href","'.$url.'?name='. $file_obj->fileName.'&id='.$file_key.' ");
      		        		anchor.setAttribute("id","'.$filesize.'");
      		        		anchor.innerHTML = "Existing Attachment :- '. $file_obj->fileName.'";
      		        		document.body.appendChild(anchor);      		        		
      		        		';
      		        		
      		        		?>
      		        		var anc = $("#"+filesize);      		        		
      		        		element.parent().append(anc);

      		        		
      		        		<?php 
      		        		
      		        	}
      		        	
      		        }
      		        
      		        ?>
				
                
            }

           
            

        }


        // console.log(element);

        <?php }?>

    });
}


</script>


