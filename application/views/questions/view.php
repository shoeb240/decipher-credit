<?php

$items = json_decode($questions);
$listsize = count($items);
?>

<div class="container">
<div class="row">
<div class="col-md-10 pull-left">


<div class="panel panel-default">
  <div class="panel-heading"><h4>Current Available Questions</h4></div>
      <div class="table-fixedheader">

        <table id='table-draggable1' style="width: 100%" class=" table-striped table-condensed table-bordered table-hover">
         <tbody class="connectedSortable">
      <tr>
         <th>ID</th>
         <th>Description</th>
         <th>Status</th>
         <th>Handler</th>
         <th>Parameters</th>
         <th></th>
      </tr>
         <?php
			for($ii=0; $ii < $listsize; $ii++) {
  			 	$iname = $items[$ii]->des;
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
				   echo !empty($items[$ii]->handler) ? $items[$ii]->handler : '1';
				   echo "</td>";

				   echo "<td>";
				   echo "{}";
				   echo "</td>";




                                   echo'<td><button type="button" onclick="showquestionContent(\''.$iid. '\',\'' .$iname.  '\')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button> 
				   
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


function showquestionContent(id,name)
{

	$.ajax({

		url: "../ajax/Question_ajax/GetQuestionContent",
		type:      'POST',
		data: {'question_id': id + "|" +name +"^" },
		success: function(result)
		{
		$("#Title").html("Question - View Post");
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
