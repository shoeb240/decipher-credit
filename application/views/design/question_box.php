<?php echo validation_errors(); 
$items = json_decode($questions);
$listsize = count($items);
?>

<div class="row">
	
    <div class="panel panel-default">
        <div class="panel-heading" onclick="colapse_details(this)"><h4>Questions</h4></div>
        <div class="table-fixedheader"  style="height: 250px;">     
            <table id='questionsList' style="width: 100%;" class=" table-striped table-condensed table-bordered table-hover">
            <tbody id="tbodyQuestion"  class="connectedSortable ">
                <tr>             
                    <th>DESCRIPTION</th>
<!--                    <th>STATUS</th>-->
                    <th>VIEW</th>
                </tr>
                <?php
                for($ii=0; $ii < $listsize; $ii++) {
                            $iname = $items[$ii]->des;
                            $qid   = $items[$ii]->id;
                            $icontent   = $items[$ii]->content;
                            $question_status = $items[$ii]->status;
                            echo "<tr>";				  
                                echo "<td>";
                                echo '<input class="qid" type="hidden" value="'.$qid.'">';
                                echo "$iname"; 
                                echo '<input class="sname" type="hidden" value="'.$iname.'">';
                                echo '<input class="ques_box" type="hidden" value="yes">';
                                echo "</td>";
                                echo '<td><button type="button" onclick="showQuestion(\''.$qid. '\',\'' .$iname.  '\')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">View</button></td>';
                            echo '</tr>';
                }
                ?>

            </tbody>
            </table>   
        </div>
    </div>

</div>
