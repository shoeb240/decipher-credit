<?php

//print_r($questions);
$items = json_decode($sections);
$listsize = count($items);
//print_r($items);
//<img id="drag1" src="img_logo.gif" draggable="true"
//ondragstart="drag(event)" width="336" height="69">
?>

<div class="container">
<div class="row">
<div class="col-md-10 pull-left">


<div class="panel panel-default">
  <div class="panel-heading"><h4>Current Available Sections</h4></div>
      <div class="table-fixedheader">
     
        <table id='table-draggable1' style="width: 100%" class=" table-striped table-condensed table-bordered table-hover">
         <tbody class="connectedSortable">
      <tr>
         <th>ID</th>
         <th>DESCRIPTION</th>
         <th>QUESTIONS</th>
         <th>STATUS</th>
         <th>VIEW</th>
         <th>EDIT</th>
      </tr>
         <?php
			for($ii=0; $ii < $listsize; $ii++) {
  			 	$iname = $items[$ii]->description;
                                $id   = $items[$ii]->id;
  				$iid   = $items[$ii]->uid;
   				
				  echo "<tr>";
				   echo "<td>";
				   echo "$iid";
				   
				   
				   echo "</td>";
				   echo "<td>";
				   echo "$iname"; 
				   echo "</td>";
                                   echo "<td>";
                                   if (!empty($sections_questions[$iid])) {
                                   echo '<ul>';
                                   foreach($sections_questions[$iid] as $each_ques) {
                                   echo "<li>$each_ques</li>"; 
                                   }
                                   echo '</ul>';
                                   }
				   echo "</td>";
				   echo "<td>";
				    //echo $items[$ii]->status;
                                   

                    if ($iid && $items[$ii]->customer_section_status == 0) { 
                        echo $iid . '==';
                    ?>

                        <a class="status_decipher" id="<?php echo $id;?>" alt="AX" href="javascript: void(0)" >Activate</a>

                    <?php   
                    } else if (!$iid) {
                    ?>

                        <a class="status_decipher" id="<?php echo $id;?>" alt="A" href="javascript: void(0)">Activate</a>

                    <?php    
                    } else {
                    ?>

                        <a class="status_decipher" id="<?php echo $id;?>" alt="D" href="javascript: void(0)">Deactivate</a>

                    <?php
                    }

                        
				   echo "</td>";				  
				   echo'<td><button type="button" onclick="showasectionContent(\''.$iid. '\',\'' .$iname.  '\')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button> 
				   
				   </td>';
				   
				   echo'<td><a href="edit/'.$iid.'"  class="btn btn-info" >Edit</a>
				   	
				   </td>';
				   echo '</tr>';				
			}
	?>
      
   </tbody>
</table>



</div>

	
</div>
</div>
</div>

<script>


function showasectionContent(id,name)
{
	 
	$.ajax({

		url: "../ajax/Section_ajax/GetCustomerSectionContent",
		type:      'POST',
		data: {'section_id': id + "|" +name +"^" },		
		success: function(result)
		{
		$("#Title").html("Section - View");		
        $("#rendered-form").html(result);

        }

    	});
    

	
	return false;

	 
}

$(".status_decipher").on("click", function() {
    var id = $(this).attr('id');
    var alt_val = $(this).attr('alt');
    var resp = '';
    
    if (alt_val === 'A')
    {
        resp = copy_from_decipher(id);
        //alert(alt_val+'=='+resp);
        if (resp === 'created')
        {
            $(this).attr('alt', 'AX');
            $(this).html('Deactivate');
        }
    }
    else if (alt_val === 'AX')
    {
        resp = change_status_copied_template(id, '1');
        //alert(alt_val+'=='+resp);
        if (resp === 'activated')
        {
            $(this).attr('alt', 'D');
            $(this).html('Deactivate');
        }
    }
    else if (alt_val === 'D')
    {
        resp = change_status_copied_template(id, '0');
        //alert(alt_val+'=='+resp);
        if (resp === 'deactivated')
        {
            $(this).attr('alt', 'AX');
            $(this).html('Activate');
        }
    }
});

function copy_from_decipher(section_id)
{
    var response = '';
     
    $.ajax({
        url: "../ajax/Section_ajax/CopyDecipherSection",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data: {'section_id': section_id, 'customer_id': <?php echo $customer_id;?>},
        success: function(result) {
            console.log(result.response);
            response = result.response;
        },
        error: function() {
            
        }
    });
    
    return response;
}

function change_status_copied_template(section_id, status)
{
    var response = '';
    $.ajax({
        url: "../ajax/Section_ajax/DeactivateCopiedSection",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data: {'section_id': section_id, 'customer_id': <?php echo $customer_id;?>, 'status': status},
        success: function(result) {
            console.log(result.response);
            response = result.response;
        },
        error: function() {
            
        }
    });
    
    return response;
}


</script>


<div class="modal fade" role="dialog" id="prevModal">  

<div class="container">
 <div class="modal-content col-md-10">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id ="Title"></h4>
      </div>
      <div class="modal-body"  id="rendered-form">
        
      </div>
 
</div>
</div>
</div>
	