<script type="text/javascript" src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<style>

.table-fixedheader
{
	
	
	height: 450px;
    overflow-y: auto;
	
}

.modal.in {
   display:block;
}

.outer:hover{
     background-color: #ee9955;
     padding: 7px;
}

/*.section:hover{
     background-color: #997777;
     padding: 7px;
}*/

.sec_wgt{
    width: 30px;
}

.ques_wgt{
    width: 30px;
}

.total_ques_wgt{
    width: 30px;
}

#total_sec_wgt{
    width: 30px;
}

</style>

<script type="text/javascript">
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}



function returnSectionContent(id,name)
{
    var res;
    
    $.ajax({
        url: "<?php echo base_url()?>index.php/ajax/Section_ajax/GetCustomerSectionContent",
        type:      'POST',
        async: false,
        data: {'section_id': id+"|"+name},		
        success: function(result) {
            res = result;
        }
    });
    
    return res;
}

function returnDecipherSectionContent(id, name)
{
    var res;
    $.ajax({
        url: "<?php echo base_url()?>index.php/ajax/Section_ajax/GetSectionContent",
        type: 'POST',
        async: false,
        data: {'section_id': id+"|"+name},		
        success: function(result) {
            res = result;
        }
    });
    
    return res;
}

function returnQuestion(id)
{
    var res;
    $.ajax({
        url: "<?php echo base_url()?>index.php/ajax/Question_ajax/GetQuestionContent",
        type:      'POST',
        async: false,
        data: {'question_id': id},		
        success: function(result) {
            res = result;
        }
    });
    
    return res;
}

function returnQuestionContentOnly(id)
{
    var res;
    $.ajax({
        url: "<?php echo base_url()?>index.php/ajax/Question_ajax/GeQuestionContentOnly",
        type:      'POST',
        async: false,
        data: {'question_id': id},		
        success: function(result) {
            res = result;
        }
    });
    
    return res;
}

function returnCustQuestionContentOnly(uid)
{
    var res;
    $.ajax({
        url: "<?php echo base_url()?>index.php/ajax/Question_ajax/GeCustQuestionContentOnly",
        type:      'POST',
        async: false,
        data: {'question_uid': uid},		
        success: function(result) {
            res = result;
        }
    });
    
    return res;
}

function showQuestionAttribute(id, type)
{
    var ques_arr = {};
    var ques_str = '';
    var qcont = '';
    var id_str = type + "_" + id;
    
    $(".outer").css("background-color", "");
    $(".outer").css("padding", "");
    $("#"+id_str).css("background-color", "#ee9955");
    $("#"+id_str).css("padding", "7px");
    
    if (ques_str = getCookie('ques_str')) {
        ques_arr = JSON.parse(ques_str);
        //console.log(ques_arr);
        if (ques_arr[id_str]) {
            qcont =  decodeURI(ques_arr[id_str]);
        }
    }
    
    if (!qcont) {
        if (type == 'deci' || type == 'indp') {
            qcont = returnQuestionContentOnly(id);
        } else {
            uid = id;
            qcont = returnCustQuestionContentOnly(uid);
        }
    }
    
    $("#attribute_id").val(id_str);
    $("#attribute").val(qcont);
}

function saveAttribute()
{
    var ques_arr = {};
    var id_str = $("#attribute_id").val();
    var qcont = $("#attribute").val();

    var ques_str = getCookie('ques_str');
    if (ques_str) {
        ques_arr = JSON.parse(ques_str);
    }
    
    var encoded = encodeURI(qcont);
    encoded = encoded.replace(/"/g, "\\\"");
    var comm = "ques_arr."+id_str+" = \"" +  encoded + "\";";
    eval(comm);
    
    //console.log(ques_arr);
    var ques_str = JSON.stringify(ques_arr);
    setCookie('ques_str', ques_str);
    //$("#"+id_str).html(qcont); // Shows questin content change at template panel
}

function close_new_sec(qsec_id, ths)
{
    $("").replaceAll($('#qsection_name_right_panel_' + qsec_id).parent().parent());
    $("").replaceAll($('#new_section_name_tr_' + qsec_id).parent());
    $("").replaceAll('#new_section_total_tr_' + qsec_id);
    $("").replaceAll($('#qsection_wgt_' + qsec_id).parent());
    
    $(ths).closest("tbody").children("tr:gt(0)").each(function (){
        var qid = $(this).find("input.qid").val();
        $("").replaceAll('.right_ques_wgt_' + qid);
    });
}


function initialize_sortable()
{
    var $tabs = $('#decipherSectionsList, #customerSectionsList, #questionsList')
    $("tbody.connectedSortable").sortable({
	//connectWith: ".connectedSortable",
        items: "> tr:not(:first)",
        appendTo: $tabs,
        helper: "clone",
        receive: function(evnt, elmnt) {
            var id = elmnt.item.find("input.id").val();
            var qid = elmnt.item.find("input.qid").val();
            var orig_id = elmnt.item.find("input.orig_id").val();
            var sname = elmnt.item.find("input.sname").val();
            var canvas = elmnt.item.find("input.canvas").val();
            var ques_box = elmnt.item.find("input.ques_box").val();
            var qsec_id = elmnt.item.parent().children(":first-child").find("input.qsec_id").val();

            if (!canvas) {
                // Dragging into template panel
                htmlcon = '<tr class="ui-sortable-handle"><td colspan="2">' + 
                          '<input type="hidden" value="'+id+'" class="id">' +
                          '<input type="hidden" value="'+sname+'" class="sname">' +
                          '<input type="hidden" value="'+orig_id+'" class="orig_id">' +
                          '<input type="hidden" value="'+qid+'" class="qid">' +
                          '<input type="hidden" value="'+qsec_id+'" class="qsec_id_'+qid+'">' +
                          '<input type="hidden" value="yes" class="canvas">';
                if (ques_box) {
                    //console.log(returnQuestion(orig_id));
                    htmlcon += '<input id="question_wgt_'+qid+'" type="hidden" value="0" class="ques_wgt" >';
                    htmlcon += '<input type="hidden" value="yes" class="ques_box">';
                    htmlcon += returnQuestion(qid);
                    $("#new_section_total_tr_"+qsec_id).before('<tr class="right_ques_wgt_'+qid+'"><td>'+sname+'</td><td><input type="text" value="0" class="ques_wgt" onchange="put_ques_wgt_in_hidden(\'question_wgt_'+qid+'\', this, \''+qsec_id+'\')"></td></tr>');
                } else {
                    if (!id) {
                        htmlcon += '<input id="section_wgt_'+orig_id+'" type="hidden" value="0" class="sec_wgt" placeholder="Section Weight" onchange="recalc_sec_wgt()">';
                        htmlcon += returnDecipherSectionContent(orig_id, sname);
                        $("#section_attribute_tbody").append('<tr class="right_sec_wgt_'+orig_id+'"><td>'+sname+'</td><td><input type="text" value="0" class="sec_wgt" onchange="put_sec_wgt_in_hidden(\'section_wgt_'+orig_id+'\', this)"></td></tr>');
                    } else {
                        htmlcon += '<input id="section_wgt_'+orig_id+'" type="hidden" value="0" class="sec_wgt" placeholder="Section Weight" onchange="recalc_sec_wgt()">';
                        htmlcon += returnSectionContent(id, sname);
                        $("#section_attribute_tbody").append('<tr class="right_sec_wgt_'+orig_id+'"><td>'+sname+'</td><td><input type="text" value="0" class="sec_wgt" onchange="put_sec_wgt_in_hidden(\'section_wgt_'+orig_id+'\', this)"></td></tr>');
                    }
                }
            } else {
                // Dragging back into left panel
                htmlcon = '<tr class="ui-sortable-handle"><td>';
                if (ques_box) {
                        htmlcon += '<input type="hidden" value="'+qid+'" class="qid">';
                        htmlcon += sname;
                        htmlcon += '<input type="hidden" value="'+sname+'" class="sname">';
                        htmlcon += '<input type="hidden" value="yes" class="ques_box">';
                        htmlcon += '</td><td>';
                        htmlcon += '<button data-target="#prevModal" data-toggle="modal" class="btn btn-info" onclick="showQuestion(\'' + qid + '\',\'' + sname + '\')" type="button">View</button>';
                        var my_qsec_id = $(".qsec_id_" + qid).val();
                        recalc_ques_wgt_ths_remove(my_qsec_id);
                        $("").replaceAll('.right_ques_wgt_' + qid);
                } else {
                    htmlcon += '<input type="hidden" value="'+id+'" class="id">';
                    htmlcon += sname;
                    htmlcon += '<input type="hidden" value="'+sname+'" class="sname">';
                    htmlcon += '<input type="hidden" value="'+orig_id+'" class="orig_id">';
                    htmlcon += '</td><td>';
                    if (!id) {
                        htmlcon += '<button data-target="#prevModal" data-toggle="modal" class="btn btn-info" onclick="showDecipherSectionContent(\'' + orig_id + '\',\'' + sname + '\')" type="button">View</button>';
                        $("").replaceAll('.right_sec_wgt_' + orig_id);
                        recalc_sec_wgt();
                    } else {
                        htmlcon += '<button data-target="#prevModal" data-toggle="modal" class="btn btn-info" onclick="showSectionContent(\'' + id + '\',\'' + sname + '\')" type="button">View</button>';
                        $("").replaceAll('.right_sec_wgt_' + orig_id);
                        recalc_sec_wgt();
                    }
                }
            }
    
            htmlcon += '</td></tr>';
            elmnt.item.replaceWith(htmlcon);
        },
    });
    
    $("#tbodyQuestion").sortable({
	connectWith: ".tbodyQuestionCanvas",
    });
    
    $(".tbodyQuestionCanvas").sortable({
	connectWith: "#tbodyQuestion",
    });
    
    $("#tbodyCustomerSection").sortable({
	connectWith: "#tbodyPanel",
    });
    
    $("#tbodyDecipherSection").sortable({
	connectWith: "#tbodyPanel",
    });
    
    $("#tbodyPanel").sortable({
	connectWith: "#tbodyCustomerSection, #tbodyDecipherSection",
    });
}

function colapse_details(ths)
{
    $(ths).parent().children('.table-fixedheader').toggle();
}

$(document).ready(function(){
    // $("#nameModal").dialog("open");
    initialize_sortable();
    setCookie('ques_str', '');
    recalc_sec_wgt();
    
});
    

</script>


<?php echo form_open('designtemplates/edit/'.$template_id); ?>


    <div class="row col-md-12">
        <div class="col-md-3" style="float: left;">
            <div class="col-md-12"><?php include("question_box.php");?></div>
            <div class="col-md-12"><?php include("customer_section_box.php");?></div>
            <div class="col-md-12"><?php include("decipher_section_box.php");?></div>
        </div>
        <div class="col-md-6" style="float: left;">
            <div class="col-md-12"><?php include("template_property_box_edit.php");?></div>
            <div class="col-md-12"><?php include("template_panel_box_edit.php");?></div>
        </div>
        <div class="col-md-3" style="float: left;">
            <div class="col-md-12"><?php include("attribute_box.php");?></div>
            <div class="col-md-12"><?php include("new_section_attribute_box.php");?></div>
            <div class="col-md-12"><?php include("section_attribute_box_edit.php");?></div>
        </div>
    </div>

    <div style="clear: both;"></div>

    <?php //include("template_property_box.php");?>

    <?php //include("section_box.php");?>

 

    <div style="margin-top: 4%"></div>

<!--    <div class="col-md-6 pull-right " id="canvas" >

        <div class="panel panel-default">-->

            <?php //include("template_panel_box.php");?>


</form>

<script>
var qsec_id = 1;    

function insert_question_block()
{
    var block_html = '<tr>' +
                    '<td colspan="2">' +
                        '<input id="qsection_wgt_'+qsec_id+'" type="hidden" value="0" class="sec_wgt" onchange="recalc_sec_wgt()">' +
                        '<div style="background-color: #cccccc; margin: 15px;">' +
                            '<table style="width: 100%;" class=" table-striped table-condensed table-bordered table-hover">' +
                               '<tbody class="connectedSortable tbodyQuestionCanvas">' +
                                   '<tr>' +
                                       '<td colspan="2" style="text-align: center; padding-top:10px;">' +
                                           '<input id="qsection_name_'+qsec_id+'" type="hidden" name="ques_block_sec_name[]" class="ques_sec_name" value=""  />' +
                                           '<input type="hidden" class="ques_block_id" name="ques_block_ids[]" value="" />' +
                                           '<input type="hidden" class="ques_wgt_id" name="ques_wgt_ids[]" value="0" />' +
                                           '<div style="margin-top:5px;">Add Questions Here&nbsp;<div style="float:right;"><a onclick="close_new_sec(\''+qsec_id+'\', this)" href="javascript: void(0);">Close</a></div></div>' +
                                           '<div style="margin-top:5px; float: left;"><h4 id="qsection_name_show_'+qsec_id+'" class="section-title"></h4></div>' +
                                           '<input type="hidden" class="qsec_id" value="'+qsec_id+'" />' +
                                       '</td>' +
                                   '</tr>' +
                               '</tbody>' +
                            '</table>' +
                         '</div>' +
                     '</td>' +
                 '</tr>';
    $('#table-draggable1 > tbody').append(block_html);

    $("#section_attribute_tbody").append('<tr><td><input id="qsection_name_right_panel_'+qsec_id+'" type="text" value="" onchange="put_name_in_hidden(\'qsection_name_'+qsec_id+'\', this)" placeholder="        Section Name" /></td><td><input type="text" value="0" class="sec_wgt" onchange="put_sec_wgt_in_hidden(\'qsection_wgt_'+qsec_id+'\', this)"></td></tr>');
    
    $("#new_section_attribute_tbody").append('<tr><td id="new_section_name_tr_'+qsec_id+'" width="75%" style="text-align: left; font-weight: bold;" colspan="2">New Unnamed Section</td></tr>');
    $("#new_section_attribute_tbody").append('<tr id="new_section_total_tr_'+qsec_id+'"><td width="75%" style="text-align: right">Total Weight:</td><td><span>0<span></td></tr>');
            
    qsec_id = qsec_id + 1;
    
    initialize_sortable();
}

function find_ids(ths) 
{
    var tmp_sids = '';
    var sid = $(ths).find("input.id").val();
    var orig_id= $(ths).find("input.orig_id").val();
    var sname = $(ths).find("input.sname").val();
    if (sid) {
        tmp_sids +=   sid + "|" +sname +"^" ;
    } else if (orig_id) {
        tmp_sids +=   "!#" + orig_id + "|" +sname +"^" ;
    }
    
    return tmp_sids;
}

function find_qids(ths) 
{
    var tmp_qids = '';
    var qid = $(ths).find("input.qid").val();
    if (qid) {
            tmp_qids +=   qid + "|question~" ;
    } 
    
    return tmp_qids + '^';
}

function showTemplate()
{
    var rows = $('#table-draggable1 > tbody > tr');
    var sids="";
    //console.log(rows);

    rows.each(function() {
        if (!$(this).find("tr").html()) {
            sids += find_ids(this);
        } else {
            $(this).find("tr").each(function() {
                sids += find_qids(this);
            });
        }
    });

    if (sids == '') {
        alert('Please select atleast one section.');
        return false;
    }

    $.ajax({
        url: "<?php echo base_url()?>index.php/ajax/Section_ajax/GetCustomerSectionContent",
        type:      'POST',
        data: {'section_id': sids},		
        success: function(result) {
            $("#Title").html("Template - View");		
            $("#rendered-form").html(result);
        }
    });

    return false;
}	

function recalc_ques_wgt_ths(id, qsec_id) {
    //console.log($(id).closest("table"));
    total_ques_wgt = 0;
    $('#'+id).closest("table").find("tr").each(function() {
        var ques_wgt =  $(this).find("input.ques_wgt").val();
        if (ques_wgt) {
            total_ques_wgt = total_ques_wgt +  Number(ques_wgt);
        }
    });
    //$('#'+id).closest("table").find(".total_ques_wgt").html(total_ques_wgt);
    $("#new_section_total_tr_"+qsec_id).find("span").html(total_ques_wgt);
}

function recalc_ques_wgt_ths_remove(my_qsec_id) {
    total_ques_wgt = 0;
    $('#qsection_name_'+my_qsec_id).closest("table").find("tr").each(function() {
        var ques_wgt =  $(this).find("input.ques_wgt").val();
        if (ques_wgt) {
            total_ques_wgt = total_ques_wgt +  Number(ques_wgt);
        }
    });
   
   $("#new_section_total_tr_"+my_qsec_id).find("span").html(total_ques_wgt);
}

function recalc_sec_wgt() {
    var rows = $('#table-draggable1 > tbody > tr');
    total_sec_wgt = 0;

    rows.each(function() {
        var sec_wgt =  $(this).find("input.sec_wgt").val();
        if (sec_wgt) {
            total_sec_wgt = total_sec_wgt +  Number(sec_wgt);
            console.log(sec_wgt);
        }
    });
    $("#total_sec_wgt").html(total_sec_wgt);
    $("#section_weight_total_calculated").html(total_sec_wgt);
}

function put_sec_wgt_in_hidden(id, ths) {
    $('#'+id).val($(ths).val());
    recalc_sec_wgt();
}

function put_ques_wgt_in_hidden(id, ths, qsec_id) {
    $('#'+id).val($(ths).val());
    recalc_ques_wgt_ths(id, qsec_id);
}

function put_name_in_hidden(id, ths) {
    $('#'+id).val($(ths).val());
    var id_show = id.replace('qsection_name_', 'qsection_name_show_');
    $('#'+id_show).html($(ths).val());
    var id_show_right = id.replace('qsection_name_', 'new_section_name_tr_');
    $('#'+id_show_right).html($(ths).val());
    
    
}

function prepareqids() {
    if($("#description").val() == '') {
        alert('Template Description is  required field.');
        $("#description").focus();
        return false;
    } else if($("#product option:selected").val() == ''){
        alert('Product is a required field.');
        $("#product").focus();
        return false;
   }
	    
    var rows = $('#table-draggable1 > tbody > tr');
    var sids="";
    var orig_ids= "";
    var sec_wgts = "";
    var total_sec_wgt = 0;
    //console.log(rows);
    var break_loop = false;
    rows.each(function() {
        if (!$(this).find("tr").html()) {
            var sid = $(this).find("input.id").val();
            var orig_id= $(this).find("input.orig_id").val();
            var sec_wgt = $(this).find("input.sec_wgt").val();
            if(sid || orig_id) {
                sids +=   sid +"," ;	
                orig_ids += orig_id + ",";
                sec_wgts += sec_wgt + ",";
                total_sec_wgt = total_sec_wgt +  Number(sec_wgt);
            }
        } else {
            var sec_wgt = $(this).find("input.sec_wgt").val();
            sec_wgts += sec_wgt + ",";
            total_sec_wgt = total_sec_wgt +  Number(sec_wgt);
            qids = '';
            tml_q = '';
            ques_wgts = '';
            total_ques_wgt = 0;
            $(this).find("tr").each(function() {
                var qid = $(this).find("input.qid").val();
                //var orig_qid = $(this).find("input.orig_qid").val();
                var ques_wgt = $(this).find("input.ques_wgt").val();
                if (qid) {
                    qids += qid +"," ;
                    tml_q +=   qid + "~";
                    ques_wgts += ques_wgt + "," ;
                    total_ques_wgt = total_ques_wgt +  Number(ques_wgt);
                }
            });
            sids +=   tml_q +"," ;
            orig_ids += tml_q + ",";
                    
            $(this).find("input.ques_block_id").val(qids);
            $(this).find("input.ques_wgt_id").val(ques_wgts);
            var ques_sec_name = $(this).find("input.ques_sec_name").val();
            if ( ques_sec_name == '') {
                alert("Section name required");
                var ques_sec_name_id = $(this).find("input.ques_sec_name").attr('id');
                var ques_sec_name_right_panel_id = ques_sec_name_id.replace('qsection_name_', 'qsection_name_right_panel_');
                $("#"+ques_sec_name_right_panel_id).focus();
                break_loop = true;
                return false;
            }
            if(Math.round(Number(total_ques_wgt)) !== 100){
                alert('New section "' + ques_sec_name + '" requires total question weight 100 ' );
                break_loop = true;
                return false;
            }
        }
    });

    if (break_loop) {
        return false;
    }

    $('#secid_list').val(sids);
    $('#orig_secid_list').val(orig_ids);
    $('#sec_wgt_list').val(sec_wgts);
    
    
    var ques_str = getCookie('ques_str');
    $("#attributes_obj").val(ques_str);

        
    if($("#secid_list").val() == '') {
        alert('Please select atleast one section.');
        return false;
    }
    
    if(Math.round(Number(total_sec_wgt)) !== 100){
        alert('100 total section weight required.' + total_sec_wgt);
        return false;
    }
    
}

function showSectionContent(id,name)
{
    $.ajax({
        url: "<?php echo base_url()?>index.php/ajax/Section_ajax/GetCustomerSectionContent",
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
        url: "<?php echo base_url()?>index.php/ajax/Section_ajax/GetSectionContent",
        type: 'POST',
        data: {'section_id': id+"|"+name},		
        success: function(result) {
            $("#Title").html("Section - View");			
            $("#rendered-form").html(result);
        }
    });
}

function showQuestion(id,name)
{
    $.ajax({
        url: "<?php echo base_url()?>index.php/ajax/Question_ajax/GetQuestionContent",
        type:      'POST',
        data: {'question_id': id},		
        success: function(result) {
            $("#Title").html("Question - "+ name);			
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

