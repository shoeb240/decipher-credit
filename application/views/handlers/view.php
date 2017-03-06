<?php
$items = json_decode($handlers);
$listsize = count($items);
?>

<div class="container">
<div class="row">
<div class="col-md-10 pull-left">


<div class="panel panel-default">
  <div class="panel-heading"><h4>Current Available Handlers</h4></div>
      <div class="table-fixedheader">
     
        <table id='table-draggable1' style="width: 100%" class=" table-striped table-condensed table-bordered table-hover">
         <tbody class="connectedSortable">
      <tr>
         <th>ID</th>
         <th>DESCRIPTION</th>
         <th>HANDLER</th>
         <th>EDIT</th>
         <th>Used in Products</th>
         <th>Used in Questions</th>
      </tr>
         <?php
			for($ii=0; $ii < $listsize; $ii++) {
  			 	$iname = $items[$ii]->description;
  				 $iid   = $items[$ii]->id;
   				 $pref   = $items[$ii]->pref;
   				 $qref   = $items[$ii]->qref;
                                 
				  echo "<tr>";
				   echo "<td>";
				   echo "$iid";
				   
				   
				   echo "</td>";
				   echo "<td>";
				   echo "$iname"; 
				   echo "</td>";
				   echo "<td>";
				    echo $items[$ii]->handler;
				   echo "</td>";
				   echo'<td><a href="edit/'.$iid.'"  class="btn btn-info" >Edit</a>';
				   echo "<td>";
				   echo "$pref"; 
				   echo "</td>";

				   echo "<td>";
				   echo "$qref"; 
				   echo "</td>";
                                   echo '</tr>';				
			}
	?>
      
   </tbody>
</table>



</div>

	
</div>
</div>
</div>