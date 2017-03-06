<?php 

echo validation_errors(); 
$items = $templ_sectiondata;
$listsize = count($templ_sectiondata);
//$remaining_items = $remaining_sections;
//$remaining_listsize = count($remaining_items);
//print_r($items);
//print_r($remaining_items);

?>
<div id="canvas" >
    
    <div class="panel panel-default">
        
        <div class="panel-heading"><h4>Drag and Drop Sections Below </h4></div>
        <div class="table-fixedheader" style="height:auto; min-height: 450px;">
            
            <table id='table-draggable1' style="width: 100%" class=" table-striped table-condensed table-bordered table-hover">
                <tbody id="tbodyPanel" class="connectedSortable">
                <tr>
                    <th>DESCRIPTION</th>
                    <th>VIEW</th>
                </tr>
                <?php
                        $totalweight=0;
			for($ii=0; $ii < $listsize; $ii++) {
  			 	$iname = $items[$ii]["description"];
  				 $iid   = $items[$ii]["id"];
  				 $orig_id   = $items[$ii]["orig_id"];
  				 $weight   = $items[$ii]["weight"];
                                 
                                echo "<tr>";
				   echo "<td colspan='5'>";
                                   $questionsCust = $items[$ii]["questions"];
                                   $all_questions_html =  "";
                                   if (!empty($questionsCust)) {
                                        $all_questions_html .= "<div name='section' class='section'><h4 class='section-title'>".$iname." </h4> ";
                                            $all_questions_html .= '<input class="id" type="hidden" value="'.$iid.'">';
                                            $all_questions_html .= '<input class="orig_id" type="hidden" value="'.$orig_id.'">';
                                            $all_questions_html .=  '<input class="sname" type="hidden" value="'.$iname.'">';
                                            $all_questions_html .=  '<input type="hidden" value="" class="qid">';
                                            $all_questions_html .=  '<input type="hidden" value="" class="qsec_id_undefined">';
                                            $all_questions_html .=  '<input type="hidden" value="yes" class="canvas">';
                                            $all_questions_html .=  '<input id="section_wgt_'.$orig_id.'" type="hidden" value="'.$weight.'" class="sec_wgt" placeholder="Section Weight" onchange="recalc_sec_wgt()">';
                                            foreach ($questionsCust as $question)
                                            {
                                                    $question_content =   $question->content;
                                                    $all_questions_html .=  "<div name='outer' onclick=\"javascript: showQuestionAttribute('".$question->uid."', 'cust');\" class = 'outer' id = 'cust_".$question->uid."' value='".$question->id."'  >" .  $question_content . "</div>";
                                            }
                                            $all_questions_html .= "</div>"; // end section
                                        }
                                        echo $all_questions_html;
                                      echo '</td>';
				   echo '</tr>';   
                                        
                                   $totalweight += $weight;
			}
	?>
            </tbody>
            </table>
            
                
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 pull-right">


            <div class="form-group"></div> 
            
            <input type="button" name="button" class = "btn btn-primary"   data-toggle="modal" data-target="#prevModal" value="Preview Template" formnovalidate onclick='return showTemplate()' />

            <input type="submit" name="submit" class = "btn btn-primary" value="Update Template" formnovalidate onclick='return prepareqids()' />
            
        </div>
    </div>
    
</div>  






            

    
    

    