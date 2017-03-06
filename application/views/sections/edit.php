<?php echo validation_errors(); 
$items = $remaining_questions;
$listsize = count($items);

$section_items =  $section_questions;
$secq_listsize = count($section_items);

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
  
  var $tabs = $('#questionsList')
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


<?php echo form_open('sections/edit/'.$sec_data[0]->id); ?>

<div class="container">
<div class="row">
<div class="col-md-6 pull-left">
	<div class="row">
	 
	 <div class="col-md-6">
             <h3>Section Name</h3>
             <div class="form-group">     
     
     <input type="text"  name="description" id="description" class="form-control"  placeholder="Description" required
     value = "<?php echo $sec_data[0]->description; ?>"  />       
    </div>
	</div>
	<div class="col-md-6">
            <h3>Section Status</h3>
    <div class="form-group"> 
        <select id="status" name="status">
            <option value="0" <?php 
            if($sec_data[0]->status==0){
            echo 'selected';} ?> >Inactive</option>
            <option value="1" <?php 
            if($sec_data[0]->status==1){
            echo 'selected';} ?> >Active</option>
            
        </select>
   
	 <input type="hidden"  name="oldstatus" id="oldstatus" class="form-control" 
                placeholder="Status"  value = "<?php echo $sec_data[0]->status; ?>" />	
	 </div>
	 <input type="hidden" id="qid_list" name ="qid_list" />
	 </div>
</div>




 

	<div class="row">
	
	<div class="panel panel-default">
  <div class="panel-heading"><h4>Drag and Drop Questions to Right</h4></div>
      <div class="table-fixedheader">
     
        <table id='questionsList' style="width: 100%;" class=" table-striped table-condensed table-bordered table-hover">
          
          
          
          <tbody id="myTable"  class="connectedSortable ">
            <tr>
              <th>ID</th>
        	 <th>Description</th>
        	 <th>Status</th>
         	<th>View</th>
            </tr>
             <?php
			for($ii=0; $ii < $listsize; $ii++) {
  			 	$iname = $items[$ii]->des;
  				 $iid   = $items[$ii]->id;
   				$status   = $items[$ii]->status;
				  echo "<tr>";
				   echo "<td>";
				   echo "$iid";
				   echo '<input class="id" type="hidden" value="'.$iid.'">';
				   
				   echo "</td>";
				   echo "<td>";
				   echo "$iname"; 
				   echo "</td>";
				   echo "<td>";
				   echo "$status"; 
				   echo "</td>";
				    echo '<td><button type="button" onclick="showQuestion(\''.$iid. '\',\'' .$iname.  '\')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button>';
				   echo '</tr>';
				}
	?>
           
          </tbody>
        </table>   
      </div>
      <div class="col-md-6 text-center">
      <ul class="pagination pagination-sm pager" id="myPager"></ul>
      </div>
	</div>

	</div>




</div>
<div style="margin-top: 4%"></div>

<div class="col-md-6 pull-right " id="canvas" >

<div class="panel panel-default">
  <div class="panel-heading"><h4>Drag and Drop Questions Below </h4></div>
      <div class="table-fixedheader">
     
        <table id='table-draggable1' style="width: 100%" class=" table-striped table-condensed table-bordered table-hover">
         <tbody class="connectedSortable">
      <tr>
         <th>ID</th>
         <th>DESCRIPTION</th>
         <th>STATUS</th>
         <th>VIEW</th>
      </tr>
      
        <?php
			for($ii=0; $ii < $secq_listsize; $ii++) {
  			 	$iname = $section_items[$ii]->des;
  				 $iid   = $section_items[$ii]->id;
   				$status   = $section_items[$ii]->status;
				  echo "<tr>";
				   echo "<td>";
				   echo "$iid";
				   echo '<input class="id" type="hidden" value="'.$iid.'">';
				   
				   echo "</td>";
				   echo "<td>";
				   echo "$iname"; 
				   echo "</td>";
				   echo "<td>";
				   echo "$status"; 
				   echo "</td>";
				   echo '<td><button type="button" onclick="showQuestion(\''.$iid. '\',\'' .$iname.  '\')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button>';
				   echo '</tr>';
				}
	?>
      
   </tbody>
</table>



</div>




</div>
<div class="row">
<div class="col-md-4 pull-right">

    <div class="form-group">
     <input type="submit" name="submit" class = "btn btn-primary" value="Update section item" formnovalidate onclick='return prepareqids()' />
</div>
</div>
</div>
</form>



<script>

function showQuestion(id,name)
{
	var baseurl = '<?php echo  base_url() . $this->config->item('index_page'); ?>'; 
	

	$.ajax({

		url:  baseurl + "/ajax/Question_ajax/GetQuestionContent"   ,
		type:      'POST',
		data: {'question_id': id},		
		success: function(result)
		{
		 $("#Title").html("Question - "+ name);			
        $("#rendered-form").html(result);

        }

    	});
	 
}
	
function prepareqids() {


	if($("#description").val() == '')
	{
     alert('Section Description is  required field.');
     return false;
    }
	

    
	
var rows = $('#table-draggable1 > tbody > tr');
var qids="";
//console.log(rows);

rows.each(function() {
    var qid = $(this).find("input.id").val();
    if(qid)
    {
	//alert(qid);	
	qids +=   qid +"," ;	
    }
    
    });

$('#qid_list').val(qids);

if($("#qid_list").val() == '')
{
 alert('Please select atleast one question.');
 return false;
}

}
</script>


<div class="modal fade" role="dialog" id="prevModal">  

<div class="container">
 <div class="modal-content col-md-10">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id ="Title">Question</h4>
      </div>
      <div class="modal-body"  id="rendered-form">
        
      </div>
 
</div>
</div>
</div>
