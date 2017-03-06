<?php echo validation_errors(); 
$items = $deciphersectiondata;
$listsize = count($deciphersectiondata);
?>

<div class="row">
	
    <div class="panel panel-default">
        <div class="panel-heading" onclick="colapse_details(this)"><h4>Decipher Sections</h4></div>
        
        <div class="table-fixedheader" style="height: 250px;">
            <table id='decipherSectionsList' style="width: 100%;" class=" table-striped table-condensed table-bordered table-hover">
            <tbody id="tbodyDecipherSection"  class="connectedSortable ">
                <tr>              
                     <th>SectionName</th>        	      
                </tr>
                
            <?php
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
                echo '</tr>';				
                
            }
            ?>
           
            </tbody>
            </table>   
        </div>     
    </div>

</div>
