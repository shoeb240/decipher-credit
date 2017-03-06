<?php 

echo validation_errors(); 
$items = $sectiondata;
$listsize = count($sectiondata);

?>


<script type="text/javascript" src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<style>

.table-fixedheader{
   height: 450px;
   overflow-y: auto;
}

.modal.in {
   display:block;
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
  var $tabs = $('#sectionsList')
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

<h1 style='text-align:center'>Template Create</h1>
<?php echo form_open('customertemplates/create'); ?>

<div class="container">
    <div class="row">
	 
        <div class="col-md-3">
            <div class="form-group">    
                <label>Template Name</label>
                 <input type="text"  name="description" id="description" class="form-control" placeholder="Template Name" required />       
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group"> 
                <label>Template Status</label>
<!--                <input type="text"  name="status" id="status" class="form-control" placeholder="Status" />	-->
                <select name="status" id="status" class="form-control" placeholder="Status">
                    <option value="1" selected="selected">Active</option>
                    <option value="0">Inactive</option>
                </select>
                 
                <input type="hidden" id="secid_list" name ="secid_list" />
                 <input type="hidden" id="orig_secid_list" name ="orig_secid_list" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group"> 
            <label>Product</label>
            <select name="product" id="product" class="form-control" style="width: 220px;">
                <option value="">--Select--</option>
                <?php
                foreach($products as $product) {
                    echo '<option value="'.$product->uuid.'">'.$product->description.'</option>';
                }
                ?>
            </select>
            </div>
        </div>


    </div>
    
    <div class="row">
        <div class="col-md-6 pull-left">
            
 

            <div class="row">

                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Drag and Drop Decipher Sections to Right</h4></div>
                    <div class="table-fixedheader">

                        <table id='sectionsList' style="width: 100%;" class=" table-striped table-condensed table-bordered table-hover">



                          <tbody id="myTable"  class="connectedSortable ">
                            <tr>              
                                 <th>SectionName</th>
                                 <th>View</th>
                                 <th>Weight</th>                 
                            </tr>
                             <?php
                                        $defaultweight=0;
                                        for($ii=0; $ii < $listsize; $ii++) {
                                                $iname = $items[$ii]["description"];
                                                $iid   = $items[$ii]["id"];
                                                $orig_id = $items[$ii]["orig_id"];
                                                //$icontent   = $items[$ii]->content;
                                                echo "<tr>";				 
                                                    echo "<td>";
                                                    echo '<input class="id" type="hidden" value="'.$iid.'">';
                                                    echo "$iname"; 
                                                    echo '<input class="sname" type="hidden" value="'.$iname.'">';
                                                    echo '<input class="orig_id" type="hidden" value="'.$orig_id.'">';
                                                    echo "</td>";
                                                    echo "<td>";
                                                    if (empty($iid)) {
                                                        echo '<button type="button" onclick="showDecipherSectionContent(\''.$orig_id. '\',\'' .$iname.  '\')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button>';
                                                    } else {
                                                        echo '<button type="button" onclick="showSectionContent(\''.$iid. '\',\'' .$iname.  '\')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button>';
                                                    }
                                                    echo "</td>";

                                                                                   echo '<td>';
                                                   echo "<input class='wgt'  value='$defaultweight' >";
                                                   echo "</input>";
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
<!--        <div style="margin-top: 4%"></div>-->

<div class="col-md-6 pull-right " id="canvas" >

<div class="panel panel-default">
    <div class="panel-heading"><h4>Drag and Drop Sections Below </h4></div>
        <div class="table-fixedheader">
     
        <table id='table-draggable1' style="width: 100%;"  class=" table-striped table-condensed table-bordered table-hover">
         <tbody class="connectedSortable">
            <tr>        
               <th>Section Name</th>
               <th>View</th>
               <th>Weight</th>
            </tr>
         </tbody>
        <?php
       $totalweight=0;
        echo "<tfoot><tr><td></td>    <td>Total Weight</td><td id='totalweight' >$totalweight</td></tr></tfoot> ";


        ?>
        </table>



        </div>




    </div>
    <div class="row">
        <div class="col-md-8 pull-right">


            <div class="form-group"></div> 
            <input type="button" name="button" class = "btn btn-primary"   data-toggle="modal" data-target="#prevModal" value="Preview Template" formnovalidate onclick='return showTemplate()' />

            <input type="submit" name="submit" class = "btn btn-primary" value="Create template item" formnovalidate onclick='return prepareqidsb()' />
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
        var orig_id= $(this).find("input.orig_id").val();
        var sname = $(this).find("input.sname").val();
        if(sid) {
            sids +=   sid + "|" +sname +"^" ;
        } else if(orig_id) {
            sids +=   "!#" + orig_id + "|" +sname +"^" ;
        }
    });

    if(sids == '') {
        alert('Please select atleast one section.');
        return false;
    }

    $.ajax({
        url: "../ajax/Section_ajax/GetCustomerSectionContent",
        type:      'POST',
        data: {'section_id': sids},		
        success: function(result) {
            $("#Title").html("Template - View");		
            $("#rendered-form").html(result);
        }
    });

    return false;
}	

function prepareqidsb() {
var nvps=[];
if($("#description").val() == ''){
     alert('Template Description is a required field.');
     $("#description").focus();
     return false;
} else if($("#product option:selected").val() == ''){
     alert('Product is a required field.');
     $("#product").focus();
     return false;
}
var rows = $('#table-draggable1 > tbody > tr').not(':first');
var members = 0;
rows.each(function() {
    var qid = $(this).find("input.id").val();
    var orig_id= $(this).find("input.orig_id").val();
    var wgt =  $(this).find("input.wgt").val();
    if(qid || orig_id){
       var nvp = {section:qid,orig_id:orig_id,weight:wgt};
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
$('#orig_secid_list').val(xnvps);
$('#secid_list').val(xnvps);//remove this after edit is done

//console.log(xnvps);
return true;
}// end prepareqidsb

function showSectionContent(id,name)
{
    $.ajax({
        url: "../ajax/Section_ajax/GetCustomerSectionContent",
        type:      'POST',
        data: {'section_id': id+"|"+name},		
        success: function(result) {
            $("#Title").html("Section - View");			
            $("#rendered-form").html(result);
        }
    });
}

function showDecipherSectionContent(id, name)
{
    $.ajax({
        url: "../ajax/Section_ajax/GetSectionContent",
        type: 'POST',
        data: {'section_id': id+"|"+name},		
        success: function(result) {
            $("#Title").html("Section - View");			
            $("#rendered-form").html(result);
        }
    });
}

</script>


<div class="modal fade"  id="nameModal">
    <form>
        <label for="name">Template Name</label>
        <input type="text" name="name" id="txtTemplate" class="text ui-widget-content ui-corner-all" />
    </form>
 </div>

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
