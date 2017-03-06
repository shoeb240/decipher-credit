<?php
$items = json_decode($templates);
$listsize = count($items);
?>

<div class="container">
<div class="row">
<div class="col-md-10 pull-left">


<div class="panel panel-default">
  <div class="panel-heading"><h4>Available Templates</h4></div>
      <div class="table-fixedheader">
     
        <table id='table-draggable1' style="width: 100%" class=" table-striped table-condensed table-bordered table-hover">
            <tbody class="connectedSortable">
                <tr>
                   <th>Template ID</th>
                   <th>Description</th>
                   <th>Owner</th>                   
                   <th>Sections</th>                   
                   <th>Status</th>
                   <th></th>
                   <th></th>
                   <th></th>
                   <th></th>
                </tr>
                
                <?php
                for($ii=0; $ii < $listsize; $ii++) {
                    $id   = $items[$ii]->id;
                    $uuid   = $items[$ii]->uuid;
                    if ($uuid) {
                        $iname = $items[$ii]->customer_template_name;
                    } else {
                        if ($items[$ii]->owner == 0 && ($items[$ii]->visibility == 0 || $items[$ii]->status == 0)) {
                            continue;
                        }
                        $iname = $items[$ii]->TemplateName;
                    }
                ?>
                
                <tr>
                    <td>
                        <?php echo "$id";?>
                    </td>
                    
                    <td>
                        <?php echo "$iname";?>
                    </td>
                    
                    <td>
                        <?php
                        if($items[$ii]->owner == 0){
                            echo "Decipher Credit";                                     
                        } else {
                            echo "Customer";
                        }
                        ?>
                    </td>
                    
                    <td>
                        <?php
                        if ($uuid) {
                            if (!empty($sections[$uuid])) {
                                echo '<ul>';
                                foreach($sections[$uuid] as $eachSection) {
                                    echo '<li><a href="'.base_url().'index.php/customersections/edit/'.$eachSection['uid'].'">'.$eachSection['description']. '&nbsp;-&nbsp;'.$eachSection['weighting'].'</a></li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<span style="padding-left: 100px;">--</span>';
                            }
                        } else {
                            if (!empty($decipher_sections[$id])) {
                                echo '<ul>';
                                foreach($decipher_sections[$id] as $eachSection) {
                                    echo '<li>'.$eachSection['description'] . '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<span style="padding-left: 100px;">--</span>';
                            }
                        }
                        ?>
                    </td>

                    <td>
                    <?php
                    if ($uuid && $items[$ii]->customer_template_status == 0) { 
                    ?>

                        <a class="status_decipher" id="<?php echo $id;?>" alt="AX" href="javascript: void(0)" >Activate</a>

                    <?php   
                    } else if (!$uuid) {
                    ?>

                        <a class="status_decipher" id="<?php echo $id;?>" alt="A" href="javascript: void(0)">Activate</a>

                    <?php    
                    } else {
                    ?>

                        <a class="status_decipher" id="<?php echo $id;?>" alt="D" href="javascript: void(0)">Deactivate</a>

                    <?php
                    }
                    ?>
                    </td>
                    
                    <td>
                        <?php   
                        if ($uuid) {
                            echo '<a href="'.base_url().'index.php/customers/'.$customer_id.'/applications/'.$id.'" class="btn btn-info">View</button>';
                        ?>
<!--                        <button type="button" onclick="showCustomerTemplateContent('<?php echo $uuid;?>', '<?php echo $iname;?>')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button> 				   -->
                        <?php   
                        } else  {
                        ?>
                            <button type="button" onclick="showTemplateContent('<?php echo $id;?>', '<?php echo $iname;?>')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button>
                        <?php   
                        }
                        ?>
                    </td>
                    
                    <td>
                        <?php   
                        if ($uuid) {
                            echo'<a href="'.base_url().'index.php/customertemplates/edit/'.$uuid.'"  class="btn btn-info" >Edit</a>';
                        } else  {
                            echo'<a class="btn btn-info disabled" >Edit</a>';    
                        }
                        ?>
                    </td>
                    
                    <td>
                        <?php   
                        if ($uuid) {
                            echo'<a href="'.base_url().'index.php/designtemplates/edit/'.$uuid.'"  class="btn btn-info" >New Edit</a>';
                        } else  {
                            echo'<a class="btn btn-info disabled" >New Edit</a>';    
                        }
                        ?>
                    </td>
                    
                    <td>
                        <?php   
                        if ($uuid) {
                        ?>
                            <button type="button" onclick="showCode('<?php echo $id;?>', this)" class="btn btn-info" data-toggle="modal" data-target="#jsCode">Code</button> 
                        <?php
                        } else {
                            echo'<a class="btn btn-info disabled" >Code</a>';    
                        }
                        ?>
                    </td>
                    
                </tr>
        <?php
        }
	?>
      
   </tbody>
</table>



</div>

	
</div>
</div>
</div>

<script>

function showTemplateContent(id,name)
{
	 

	$.ajax({

		url: "../ajax/Template_ajax/GetTemplateContent",
		type:      'POST',
		data: {'template_id': id},		
		success: function(result)
		{
		 $("#Title").html("Template - " + name);			
        $("#rendered-form").html(result);

        }

    	});
	 
}

function showCustomerTemplateContent(id,name)
{
	 

	$.ajax({

		url: "../ajax/Template_ajax/GetCustomerTemplateContent",
		type:      'POST',
		data: {'template_id': id},		
		success: function(result)
		{
		 $("#Title").html("Template - " + name);			
        $("#rendered-form").html(result);

        }

    	});
	 
}

$(".status_decipher").on("click", function() {
    var id = $(this).attr('id');
    var alt_val = $(this).attr('alt');
    var resp = '';
    
    if (alt_val === 'A')
    {
        resp = copy_from_decipher(id);
        //alert(alt_val+'=='+resp);
        if (resp === 'created')
        {
            $(this).attr('alt', 'AX');
            $(this).html('Deactivate');
        }
    }
    else if (alt_val === 'AX')
    {
        resp = change_status_copied_template(id, '1');
        //alert(alt_val+'=='+resp);
        if (resp === 'activated')
        {
            $(this).attr('alt', 'D');
            $(this).html('Deactivate');
        }
    }
    else if (alt_val === 'D')
    {
        resp = change_status_copied_template(id, '0');
        //alert(alt_val+'=='+resp);
        if (resp === 'deactivated')
        {
            $(this).attr('alt', 'AX');
            $(this).html('Activate');
        }
    }
});

function copy_from_decipher(template_id)
{
    var response = '';
     
    $.ajax({
        url: "../ajax/Template_ajax/CopyDecipherTemplate",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data: {'template_id': template_id, 'customer_id': <?php echo $customer_id;?>},
        success: function(result) {
            console.log(result.response);
            response = result.response;
        },
        error: function() {
            
        }
    });
    
    return response;
}

function change_status_copied_template(template_id, status)
{
    var response = '';
    $.ajax({
        url: "../ajax/Template_ajax/DeactivateCopiedTemplate",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data: {'template_id': template_id, 'customer_id': <?php echo $customer_id;?>, 'status': status},
        success: function(result) {
            console.log(result.response);
            response = result.response;
        },
        error: function() {
            
        }
    });
    
    return response;
}

function showCode(template_id, ths)
{
    $(ths).attr('disabled','disabled'); 
    $.ajax({
        url: '<?php echo base_url(). $this->config->item('index_page')."/ajax/Template_ajax/getTemplateJsCode"; ?>',
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data: {'template_id': template_id},
        success: function(result) {
            $("#template_code").text(result.response);
        },
        error: function() {
            
        }
    });
    $(ths).removeAttr('disabled');    
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


<div class="modal fade" role="dialog" id="jsCode">  

    <div class="container">
        <div class="modal-content col-md-10">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Code</h4>
            </div>
            <div class="modal-body">
                <textarea id="template_code" style="width: 100%; height: 100px;" readonly="true"></textarea>
          </div>
        </div>
    </div>
    
</div>
	
