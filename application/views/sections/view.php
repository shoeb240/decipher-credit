<?php
$items = json_decode($sections);
$listsize = count($items);
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
         <th>Description</th>
         <th>Status</th>
         <th>Visibility</th>
         <th>Owner</th>
         <th></th>
         <th></th>
      </tr>
         <?php
			for($ii=0; $ii < $listsize; $ii++) {
  			 	$iname = $items[$ii]->description;
  				 $iid   = $items[$ii]->id;
   				
				  echo "<tr>";
				   echo "<td>";
				   echo "$iid";
				   
				   
				   echo "</td>";
				   echo "<td>";
				   echo "$iname"; 
				   echo "</td>";
				   echo "<td>";
                                   if($items[$ii]->status==1){
                                       echo "Active";
                                      
                                   }else {
                                      echo "Inactive";
                                   }
//				    echo $items[$ii]->status;
				   echo "</td>";				  
			
				   echo "<td>";
                                   if($items[$ii]->visibility==1){
                                       echo "Public";
                                       
                                   }else {
//				    echo $items[$ii]->visibility;
                                      echo "Private";
                                   }
				   echo "</td>";				  
                        	   echo "<td>";
                                   if($items[$ii]->owner==0){
                                       
                                     echo "Decipher Credit";                                     
                                   }else {
				    echo $items[$ii]->nameLast;
                                       
                                   }
//				    echo $items[$ii]->owner;
			            echo "</td>";				  
            
                                   
                                   echo'<td><button type="button" onclick="showasectionContent(\''.$iid. '\',\'' .$iname.  '\')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button> 
				   
				   </td>';
				   
				   echo'<td>';
                                   if($items[$ii]->owner==0){
				   echo'<a href="edit/'.$iid.'"  class="btn btn-info" >Edit</a>';	
                                   } else {
                                   echo'<a class="btn btn-info disabled" >Edit</a>';	    
                                   }
				   echo '</td>';
                                   
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

		url: "../ajax/Section_ajax/GetSectionContent",
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
	