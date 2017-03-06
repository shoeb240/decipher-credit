<div class="row">
	
    <div class="panel panel-default">
        <div class="panel-heading"><h4>Sections Weight</h4></div>
        
        <div class="table-fixedheader" style="height: auto;">
            <table style="width: 100%;" class=" table-striped table-condensed table-bordered table-hover">
            <tbody id="section_attribute_tbody"  class="connectedSortable ">
                <tr>              
                    <td>Section Name</td>        	      
                    <td>Weight</td>        	      
                </tr>
                <?php
                $totalweight=0;
                for($ii=0; $ii < $listsize; $ii++) {
                    $iname = $items[$ii]["description"];
                     $iid   = $items[$ii]["id"];
                     $orig_id   = $items[$ii]["orig_id"];
                     $weight   = $items[$ii]["weight"];
                    //$icontent   = $items[$ii]->content;
                     $totalweight += $weight;
                     
                ?>
                
                <tr class="right_sec_wgt_<?php echo $orig_id;?>">
                    <td><?php echo $iname;?></td>
                    <td>
                        <input type="text" value="<?php echo $weight;?>" class="sec_wgt" onchange="put_sec_wgt_in_hidden('section_wgt_<?php echo $orig_id;?>', this)">
                    </td>
                </tr>
                
                <?php
                }
                ?>
            </tbody>
            <tfoot id="section_attribute_tbody"  class="connectedSortable ">
                <tr>              
                    <td style="text-align: right;">Total Section Weight:</td>        	      
                    <td><span id="section_weight_total_calculated"><?php echo $totalweight;?></span></td>        	      
                </tr>
            </tfoot>
            </table>   
        </div>     
    </div>

</div>
