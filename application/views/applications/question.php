<!--<pre><?php print_r($answers) ?></pre>-->
<?php
$app = json_decode($applications);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 pull-left">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Question Details <?php //echo $questionId ?></h4>
                    <p><span style="margin-right: 20px;"><span style="font-weight: bold">Applicant:</span> <?php echo $app[0]->applicant_name;?></span> 
                        <span style="margin-right: 20px;"><span style="font-weight: bold">Template:</span> <?php echo $app[0]->template_name;?></span>
                        <span style="margin-right: 20px;"><span style="font-weight: bold">Application Date:</span> <?php echo $app[0]->application_date;?></span>
                    </p>
                </div>
                <div style="padding: 10px; float: right;">
                    <button id="rerun" type="button" onclick="rerun('<?php echo $questionId ?>')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">Rerun</button>
                    <button id="rescore" type="button" onclick="rescore('<?php echo $questionId ?>')" class="btn btn-info" data-toggle="modal" data-target="#prevModal">Rescore</button>
                </div>
                <div style="padding: 10px; clear: both;">
                    <table id="answers" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Answer Id</th>
                                <th>Answer Date</th>
                                <th>Data Source</th>
                                <th>Answer</th>
                                <th>Scoring Rule</th>
                                <th>Source Score</th>
                                <th>Source Weight</th>
                            </tr>
                        </thead>
                        <!-- <tfoot style="display: table-header-group;"> -->
                        <tfoot>
                            <tr>
                                <th class="filter_small">Id</th>
                                <th class="filter">Answer Date</th>
                                <th class="filter">Data Source</th>
                                <th class="filter">Answer</th>
                                <th class="filter">Scoring Rule</th>
                                <th class="filter_small">Score</th>
                                <th class="filter_small">Weight</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($answers as $key => $q) { ?>
                            <tr>
                                <td><?php echo $q['uuid'] ?></td>
                                <td><?php echo $q['answerDate'] ?></td>
                                <td><?php echo $q['source'] ?></td>
                                <td>
                                    <?php if ($q['dsource'] == 0):?>
                                    <textarea rows="2" cols="25"><?php echo $q['answerblob'] ?></textarea>
                                    <?php else:?>
                                    <a href="javascript: void(0);" onclick="show_answer('<?php echo $q['uuid'] ?>', this);">Show</a>
                                    <?php endif;?>
                                </td>
                                <td><?php //echo $q['scoring_rule'] ?></td>
                                <td><?php echo $q['sourceScore'] ?></td>
                                <td><?php echo $q['sourceWeight'] ?></td>
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

    // values of all the textarea in a column 
    $.fn.dataTable.ext.order['dom-textarea'] = function  ( settings, col ) {
        return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
            return $('textarea', td).val();
        } );
    }
    
    // add a text input to each footer cell
    $('#answers tfoot th.filter').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" />' );
    } );
    $('#answers tfoot th.filter_small').each( function () {
        var title = $(this).text();
        $(this).html( '<input style="width: 50px;" type="text" placeholder="'+title+'" />' );
    } );


    var ansTable = $('#answers').DataTable( {
        "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
        "columns": [
            null,
            null,
            null,
            { "orderDataType": "dom-textarea", type: 'string' },
            null,
            null,
            null
        ]
    } );


    // Apply the search
    ansTable.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        } );
    } );

} );

function show_answer(uuid, ths)
{
    $.ajax({
        url: "../../ajax/Question_ajax/GetAnswerblob",
        type: 'POST',
        data: {"uuid": uuid},
        dataType: 'json',
        async: false,
        success: function(result){
            var ans = '<textarea rows="2" cols="25">'+result.answerblob+'</textarea>';
            $(ths).parent().html(ans);
        },
        error: function(){
            
        }
    });
}

function rerun(question_id)
{
    $("#rerun").attr('disabled','disabled'); 
    $.ajax({
        url: '<?php echo base_url(). $this->config->item('index_page').'/ajax/Question_ajax/RerunHandler'; ?>',
        type: 'post',
        data: {'question_id': question_id},
        postType: 'json',
        async: false,
        success: function(result){
            console.log(result);
            location.href = '<?php echo base_url(). $this->config->item('index_page').'//applications/question/' . $questionId; ?>';
        },
        error: function(){
        }
    });
    $("#rerun").removeAttr('disabled'); 
}


function rescore(question_id)
{
    $("#rescore").attr('disabled','disabled'); 
    $.ajax({
        url: '<?php echo base_url(). $this->config->item('index_page').'/ajax/Question_ajax/RescoreHandler'; ?>',
        type: 'post',
        data: {'question_id': question_id},
        postType: 'json',
        async: false,
        success: function(result){
            console.log(result);
            location.href = '<?php echo base_url(). $this->config->item('index_page').'//applications/question/' . $questionId; ?>';
        },
        error: function(){
        }
    });
    $("#rescore").removeAttr('disabled'); 
}
</script>
