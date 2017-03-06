<?php echo validation_errors(); 
$items = json_decode($questions);
$listsize = count($items);

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
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 7,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);
    
    var listElement = $this;
    var perPage = settings.perPage; 
    var children = listElement.children();
    var pager = $('.pager');
    
    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }
    
    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }
    
    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }
    
    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }
    
    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
  	pager.children().eq(1).addClass("active");
    
    children.hide();
    children.slice(0, perPage).show();
    
    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });
    
    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }
     
    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }
    
    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;
        
        children.css('display','none').slice(startAt, endOn).show();
        
        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }
        
        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }
        
        pager.data("curr",page);
      	pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");
    
    }
};

$(document).ready(function(){
    
  $('#nopaging').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:5});

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

    <h1 style='text-align:center'>Create New Section</h1>

<?php echo form_open('sections/create'); ?>

<div class="container">
<div class="row">
<div class="col-md-6 pull-left">
	<div class="row">
	 
	 <div class="col-md-4">
             <h3>Section Name</h3>
    <div class="form-group">    
     <input type="text"  name="description" id="description" class="form-control" placeholder="Description" required />       
    </div>
	</div>
	<div class="col-md-4">
            <h3>Section Status</h3>
    <div class="form-group"> 
            <select class="form-control" id="status" name="status">
            <option value="0" >Inactive</option>
            <option value="1" selected >Active</option>
            </select>   
 
        
        
	 <input type="hidden"  name="oldstatus" id="oldstatus" class="form-control" placeholder="Status" />	
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
        	 <th>DESCRIPTION</th>
        	 <th>STATUS</th>
         	<th>VIEW</th>
            </tr>
             <?php
			for($ii=0; $ii < $listsize; $ii++) {
  			 	$iname = $items[$ii]->des;
  				 $iid   = $items[$ii]->id;
   				$icontent   = $items[$ii]->content;
   				$status = $items[$ii]->status;
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
   </tbody>
</table>



</div>




</div>
<div class="row">
<div class="col-md-4 pull-right">

    <div class="form-group">
     <input type="submit" name="submit" class = "btn btn-primary" value="Create section item" formnovalidate onclick='return prepareqids()' />
</div>
</div>
</div>
</form>

<script>


function showQuestion(id,name)
{
	 

	$.ajax({

		url: "../ajax/Question_ajax/GetQuestionContent",
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

