<?php 

echo validation_errors(); 
$items = $remaining_questions;
$listsize = count($items);
$section_items =  $section_questions;
$secq_listsize = count($section_items);

?>

<script type="text/javascript" src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<style>

.table-fixedheader{
   height: 450px;
   overflow-y: auto;

}

</style>

<script type="text/javascript">

function recalc() {
    var rows = $('#table-draggable1 > tbody > tr').not(':first');
    var totalweight = 0;
    rows.each(function() {
            var wgt =  $(this).find("input.wgt").val();
            totalweight = totalweight +  Number(wgt);
    });
    $('#totalweight').html(totalweight);
}

$(document).ready(function(){
  
  var $tabs = $('#questionsList')
	$("tbody.connectedSortable")
	    .sortable({
	        connectWith: ".connectedSortable",
	        items: "> tr:not(:first)",
	        appendTo: $tabs,
	        helper: "clone",
	        zIndex: 999990
	    });
            
     $( "#table-draggable1" ).change(function() {
      recalc();
      });
     
    
});


</script>

<h1 style='text-align:center'>Section Edit</h1>

<?php echo form_open('Customersections/edit/'.$sec_data[0]->uid); ?>

<div class="container">
<div class="row">
<div class="col-md-6 pull-left">
	<div class="row">
	 
	 <div class="col-md-6">
    <div class="form-group">     
        <label>Section Description</label>
     <input type="text"  name="description" id="description" class="form-control"  placeholder="Description" required
     value = "<?php echo $sec_data[0]->description; ?>"  />       
    </div>
	</div>
	<div class="col-md-6">
    <div class="form-group"> 
        <label>Section Status</label>
	 <input type="text"  name="status" id="status" class="form-control" placeholder="Status"  value = "<?php echo $sec_data[0]->status; ?>" />	
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
            <tr class='header'>
              <th>ID</th>
        	 <th>DESCRIPTION</th>
        	 <th>STATUS</th>
         	<th>VIEW</th>
                <th>WGT</th>

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
  				   echo "<td>";
                                   echo "<input class='wgt'   value='0' >";
	                           echo "</input>";
                                   echo "</td>";

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

      <tr class='header'>
         <th>ID</th>
         <th>DESCRIPTION</th>
         <th>STATUS</th>
         <th>VIEW</th>
         <th>WGT</th>
      </tr>
      
        <?php
        $totalweight=0;
			for($ii=0; $ii < $secq_listsize; $ii++) {
  	            	 	$iname = $section_items[$ii]->des;
  				 $iid   = $section_items[$ii]->id;
   				$status   = $section_items[$ii]->status;
   				$weight   = $section_items[$ii]->weighting;
//                                $weight = $ii;
                                
				$totalweight+=$weight;
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
				   echo "<td>";
                                   echo "<input class='wgt'  value='$weight' >";
	                           echo "</input>";
                                   echo "</td>";

                                   
                                   echo '</tr>';
				}
 	?>
      
   </tbody>
<?php
echo "<tfoot><tr><td></td><td></td>    <td></td><td>Total Weight</td><td id='totalweight' >$totalweight</td></tr></tfoot> ";


?>
</table>



</div>




</div>
<div class="row">
<div class="col-md-4 pull-right">

    <div class="form-group">
     <input type="submit" name="submit" class = "btn btn-primary" 
            value="Update section item" formnovalidate 
            onclick='return prepareqidsb()' />
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
	
function prepareqidsb() {
var nvps=[];
if($("#description").val() == ''){
     alert('Section Description is a required field.');
     return false;
}
var rows = $('#table-draggable1 > tbody > tr').not(':first');
var members = 0;
rows.each(function() {
    var qid = $(this).find("input.id").val();
    var wgt =  $(this).find("input.wgt").val();
    if(qid){
       var nvp = {qid:qid,weight:wgt};
       nvps.push(nvp);
       members+=1;
    }
 });

if(members == 0){
 alert('Please select atleast one question.');
 return false;
}
var tweight= $("#totalweight").html();
if(Math.round(Number(tweight)) !== 100){
     alert('100 total weight required.');
     return false;
}
var xnvps = JSON.stringify(nvps);
$('#qid_list').val(xnvps);
return true;
}// end prepareqids

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
