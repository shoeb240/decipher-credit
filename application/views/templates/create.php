<?php echo validation_errors(); 
$items = $sectiondata;
$listsize = count($sectiondata);

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

	/*var my_text=prompt('Enter Template Name');
	 if(my_text) alert(my_text); */
	
  var $tabs = $('#sectionsList')
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

<h1 style='text-align:center;' >Create New Template</h1>
<?php echo form_open('templates/create'); ?>

<div class="container">
<div class="row">
<div class="col-md-6 pull-left">
	<div class="row">
	 
	 <div class="col-md-4">
              <h3>Template Name</h3>
    <div class="form-group">    
     <input type="text"  name="description" id="description" class="form-control" placeholder="Description" required />       
    </div>
	</div>
	<div class="col-md-4">
             <h3>Template Status</h3>
    <div class="form-group"> 

     <select class="form-control" id="status" name="status">
            <option value="0" >Inactive</option>
            <option value="1" selected >Active</option>
            
        </select>   
        <input type="hidden"  name="oldstatus" id="oldstatus" class="form-control" placeholder="Status" />	
	
    </div>
	 <input type="hidden" id="secid_list" name ="secid_list" />
	 </div>
</div>




 

	<div class="row">
	
	<div class="panel panel-default">
  <div class="panel-heading"><h4>Drag and Drop Sections to Right</h4></div>
      <div class="table-fixedheader">
     
        <table id='sectionsList' style="width: 100%;" class=" table-striped table-condensed table-bordered table-hover">
          
          
          
          <tbody id="myTable"  class="connectedSortable ">
            <tr>
              <th>ID</th>
        	 <th>DESCRIPTION</th>
        	 <th>STATUS</th>
        	 <th>VIEW</th>         
            </tr>
             <?php
			for($ii=0; $ii < $listsize; $ii++) {
  			 	$iname = $items[$ii]["description"];
  				 $iid   = $items[$ii]["id"];
   				//$icontent   = $items[$ii]->content;
				  echo "<tr>";
				   echo "<td>";
				   echo "$iid";
				   echo '<input class="id" type="hidden" value="'.$iid.'">';
				   
				   echo "</td>";
				   echo "<td>";
				   echo "$iname"; 
				   echo '<input class="sname" type="hidden" value="'.$iname.'">';
				   
				   echo "</td>";
				   echo "<td>";
				    echo $items[$ii]["status"];
				   echo "</td>";
				   
				  
				echo'<td><button type="button" onclick="showSectionContent(\''.$iid. '\',\'' .$iname.  '\')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button> 
				   
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
<div style="margin-top: 4%"></div>

<div class="col-md-6 pull-right " id="canvas" >

<div class="panel panel-default">
  <div class="panel-heading"><h4>Drag and Drop Sections Below </h4></div>
      <div class="table-fixedheader">
     
        <table id='table-draggable1' style="width: 100%;"  class=" table-striped table-condensed table-bordered table-hover">
         <tbody class="connectedSortable">
      <tr>
         <th>ID</th>
         <th>DESCRIPTION</th>
         <th>CONTENT</th>
         <th>STATUS</th>
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

function showTemplate()
{


	
	var rows = $('#table-draggable1 > tbody > tr');
	var sids="";
	//console.log(rows);

	rows.each(function() {
	    var sid = $(this).find("input.id").val();
	    var sname = $(this).find("input.sname").val();
	    if(sid)
	    {
		//alert(qid);	
		sids +=   sid + "|" +sname +"^" ;	
	    }
	    
	    });

	if(sids == '')
	{
	 alert('Please select atleast one section.');
	 return false;
	}

	
	$.ajax({

		url: "../ajax/Section_ajax/GetSectionContent",
		type:      'POST',
		data: {'section_id': sids},		
		success: function(result)
		{
		$("#Title").html("Template - View");		
        $("#rendered-form").html(result);

        }

    	});
    

	
	return false;
}	

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

function showSectionContent(id,name)
{
	 

	$.ajax({

		url: "../ajax/Section_ajax/GetSectionContent",
		type:      'POST',
		data: {'section_id': id+"|"+name},		
		success: function(result)
		{
		 $("#Title").html("Section - View");			
        $("#rendered-form").html(result);

        }

    	});
	 
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
