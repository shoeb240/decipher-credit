<?php 
$items = $customers;
$listsize = count($customers);
?>
<script type="text/javascript" src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<style>

.table-fixedheader
{
	
	
	height: 450px;
    overflow-y: auto;
	
}

</style>

<script type="text/javascript">


$(document).ready(function(){

  var $tabs = $('#usersList')
	$("tbody.connectedSortable")
	    .sortable({
	        connectWith: ".connectedSortable",
	        items: "> tr:not(:first)",
	        appendTo: $tabs,
	        helper: "clone",
	        zIndex: 999990
	    })
    
});


</script>

<div class="container">
<div class="row">
<div class="col-md-6 pull-left">
	<div class="row">
	 
	 <div class="col-md-4">
    <div class="form-group">    
     <input type="text"  name="description" id="description" class="form-control" placeholder="Description" required />       
    </div>
	</div>
	<div class="col-md-4">
    <div class="form-group"> 
	 <input type="text"  name="status" id="status" class="form-control" placeholder="Status" />	
	 </div>
	 <input type="hidden" id="secid_list" name ="secid_list" />
	 </div>
</div>


	<div class="row">
	
	<div class="panel panel-default">
  <div class="panel-heading"><h4>Drag and Drop Users to Right</h4></div>
      <div class="table-fixedheader">
     
        <table id='usersList' style="width: 100%;" class=" table-striped table-condensed table-bordered table-hover">
          
          
          
          <tbody id="myTable"  class="connectedSortable ">
            <tr>
              <th>ID</th>
        	 <th>Email</th>
        	 <th>First Name</th>
        	 <th>Last Name</th>
            </tr>
            <tr>
                 <td>
<?php
      foreach ($users as $user){
      echo "<tr>";
      echo "<td>";
      echo $user->id;
      echo "</td>";

      echo "<td>";
      echo $user->email;
      echo "</td>";
      
      echo "<td>";
      print_r($user->first_name);
      echo "</td>";
      
      echo "<td>";
      print_r($user->last_name);
      echo "</td>";

      echo "</tr>";
      
          }
?>
                 </td>
            </tr>
          </tbody>
        </table>   
      </div>     
	</div>

	</div>




</div>
<div style="margin-top: 4%"></div>

<div class="col-md-6 pull-right " id="canvas" >

<div class="panel panel-default">
  <div class="panel-heading"><h4>Drag and Drop Users Below </h4></div>
      <div class="table-fixedheader">
     
        <table id='table-draggable1' style="width: 100%;"  class=" table-striped table-condensed table-bordered table-hover">
         <tbody class="connectedSortable">
      <tr>
         <th>ID</th>
         <th>Email</th>
         <th>First Name</th>
         <th>Last Name</th>
         
      </tr>
   </tbody>
</table>



</div>




</div>
<div class="row">
<div class="col-md-8 pull-right">


    <div class="form-group"></div> <input type="button" name="button" class = "btn btn-primary"   data-toggle="modal" data-target="#prevModal" value="Preview Template" formnovalidate onclick='return showTemplate()' />
    
     <input type="submit" name="submit" class = "btn btn-primary" value="Create template item" formnovalidate onclick='return prepareqids()' />
	</div>
</div>
</div>
</form>

<script>
function prepareqids() {


	if($("#description").val() == '')
	{
     alert('Template Description is  required field.');
     return false;
    }
    
	    
	
var rows = $('#table-draggable1 > tbody > tr');
var sids="";
//console.log(rows);

rows.each(function() {
    var sid = $(this).find("input.id").val();
    if(sid)
    {
	//alert(qid);	
	sids +=   sid +"," ;	
    }
    
    });

$('#secid_list').val(sids);

if($("#secid_list").val() == '')
{
 alert('Please select atleast one section.');
 return false;
}

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
