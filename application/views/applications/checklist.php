<!--<pre><?php print_r($checklists) ?></pre>-->
<?php
$app = json_decode($applications);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 pull-left">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Checklists <?php //echo $questionId ?></h4>
                    <p><!--<span style="margin-right: 20px;"><span style="font-weight: bold">Applicant:</span> <?php //echo $app[0]->applicant_name;?></span> -->
                        <span style="margin-right: 20px;"><span style="font-weight: bold">Template:</span> <?php echo $app[0]->template_name;?></span>
                        <!--<span style="margin-right: 20px;"><span style="font-weight: bold">Application Date:</span> <?php //echo $app[0]->application_date;?></span>-->
                    </p>
                </div>
                <div style="padding: 10px; clear: both;">
                    <table id="checklist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Checklist</th>
                                <th>Answer</th>
                            </tr>
                        </thead>
                        <!-- <tfoot style="display: table-header-group;"> -->
                        <tfoot>
                            <tr>
                                <th class="filter_small">Id</th>
                                <th class="filter">Checklist</th>
                                <th class="filter">Answer</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($checklists as $key => $eachChecklist) { ?>
                            <tr>
                                <td><?php echo $eachChecklist['uuid'] ?></td>
                                <td><?php echo $eachChecklist['label'] ?></td>
                                <td><?php echo $eachChecklist['answer'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

    // add a text input to each footer cell
    $('#checklist tfoot th.filter').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" />' );
    } );
    $('#checklist tfoot th.filter_small').each( function () {
        var title = $(this).text();
        $(this).html( '<input style="width: 50px;" type="text" placeholder="'+title+'" />' );
    } );


    var checklistTable = $('#checklist').DataTable( {
        "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
        "columns": [
            null,
            null,
            null,
        ]
    } );


    // Apply the search
    checklistTable.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        } );
    } );

} );
</script>
