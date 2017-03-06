<?php
//print_r($productchecklist);
$title=null;
if (!empty($productchecklist[0])){
 //   print_r($productchecklist[0]->description);
    
}

?>
<style>
    .table-fixedheader {
        padding: 10px 15px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-10 pull-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Product Checklist</h4>
                </div>
                <div class="table-fixedheader">
                    <table id="checklist" class="table table-striped table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Checklist Item</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productchecklist as $item): ?>
                                <tr>
                                  
                                  <td>
                                      <?php echo $item->description; ?>
                                  </td>
                                  
                                  
                                  <td>
                                      <?php echo $item->label; ?>
                                  </td>
                                  <td>
         <a  alt="<?php echo $item->status;?>"  class="status_decipher" id="<?php echo $item->uuid;?>"  href="javascript: void(0)">
                                        <?php 
                                        if($item->status == 1){
                                            
                                            echo "On";
                                        }else {
                                        echo $item->status;
                                            echo "Off";
                                        }
                                        ?>
                                      </a>
                                  </td>
                                  
                                  

                                  
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#checklist').DataTable({
            "order": [[ 1, "asc" ]]
        });
    });
    $(".status_decipher").on("click", function() {
        alert("click");
    var id = $(this).attr('id');
    var alt_val = $(this).attr('alt');
    var resp = '';
    
    if (alt_val === 'A')
    {
    }
    else if (alt_val === 'AX')
    {
    }
    else if (alt_val === 'D')
    {
    }
});
    
</script>
