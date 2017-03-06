<!--<pre><?php //print_r($applications[0]->application_id) ?></pre>-->
<?php
$app = json_decode($applications);
?>
<style>
    a.link_normal {
        color: #333;
        
    }
    a.link_normal:hover {
        text-decoration: none;
        
    }
    img.save_cancel_img {
        margin-left: 5px;
        width: 12px;
    }
    </style>
<div class="container">
    <div class="row">
        <div class="col-md-12 pull-left">
        
            <div id="app_ques_list" class="panel panel-default">
                <div class="panel-heading">
                    <h4>Question List</h4>
                    <p><span style="margin-right: 20px;"><span style="font-weight: bold">Applicant:</span> <?php echo $app[0]->applicant_name;?></span> 
                        <span style="margin-right: 20px;"><span style="font-weight: bold">Template:</span> <?php echo $app[0]->template_name;?></span>
                        <span style="margin-right: 20px;"><span style="font-weight: bold">Application Date:</span> <?php echo $app[0]->application_date;?></span>
                        <span style="margin-right: 20px;"><span style="font-weight: bold">Application Score:</span> <?php echo $app[0]->score;?></span>
                    </p>
                </div>
                <div class="my-details-body">

                    <div class="tree" style="border: none; background-color: white; box-shadow: none;">
                    </div>


                </div>
            </div>
        
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function(){
    // default behavior
    $.extend( true, $.fn.dataTable.defaults, {
       // "searching": false,
       // "ordering": false
    } );
    
    //var application_id = <?php echo $application_id;?>; //appTable.cell( ths ).data();
    //var tc = AppTreeView.build(application_id);
    var tc = AppTreeView.build();

    //$('.panel-heading .score', '#app_ques_list').html( application_id );
    $('.my-details-body div.tree', '#app_ques_list').html( tc );
    //$('#app_ques_list').modal();

    AppTreeView.init('#app_ques_list');

    // reset before modal close
    $('#app_ques_list').on('hide.bs.details', function () {
        // $('#app_ques_list .tree li:has(ul)').find(' > span > i').removeClass('glyphicon-minus-sign').addClass('glyphicon-plus-sign');
        // $('#app_ques_list .tree li.parent_li > span').off('click');
        $('#app_ques_list div.tree *').off();
        $('.my-details-body div.tree', '#app_ques_list').html( '' );
    });

});

var AppTreeView = AppTreeView || {

    sectionData: [],
    //data: [],
    siteUrl: '',

    //build: function(application_id) {
    build: function() {
        var htm = '';
        var a = 0;
        /*var appsNum = this.data.length;

        while (a < appsNum) {
            if (this.data[a].application_id == application_id)  break;
            a++;
        }
        // if not match
        if (a >= appsNum)   return htm; */
        
        //var app = this.data[a];
        //this.sectionData = AppTreeView.getSectionsQuestions(app.application_id);
        var sections = this.sectionData;

        if (sections.length) {
            var secsNum = sections.length;
            for (var s = 0; s < secsNum; s++) {
                htm += '<li id="qtbldt-'+a+'-'+s+'" class="qtbldt">    <span><i class="glyphicon glyphicon-plus-sign"></i> '+sections[s].name+' &nbsp;&nbsp;&nbsp;Weight '+sections[s].weight+'% &nbsp;&nbsp;&nbsp;Score '+sections[s].score+'</span> \
                            <ul>';

                if (sections[s].questions.length) {
                    htm += '<li style="left: -40px;">\
                                </li>\
                            </ul>';
                } 

                htm += '</li>';
            }

            htm =  '<ul>\
                        <li> \
                            <ul>\
                                '+htm+'\
                            </ul>\
                        </li>\
                    </ul>';
        } else {
            htm =  '<ul>\
                        <li> '+app.applicant_name+'</span></li>\
                    </ul>';
        }
        return htm;
    },


    init: function(details) {
        $(details+' .tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Expand this branch');

        $(details+' .tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
                
                // destroy datatables of questions
                if ($(this).parent().hasClass('qtbldt') && $(this).parent().has('table')) {
                    var idData = $(this).parent().attr('id').split('-');
                    if (idData.length > 2) {
                        AppTreeView.resetQuestTable($(this).parent().attr('id'), idData[1], idData[2]);
                    }
                }
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
                
                // insert datatables for question
                if ($(this).parent().hasClass('qtbldt')) {
                    var idData = $(this).parent().attr('id').split('-');
                    if (idData.length > 2) {
                        AppTreeView.initQuestTable($(this).parent().attr('id'), idData[1], idData[2]);
                    }
                }
            }
            e.stopPropagation();
        });

        //$(details+' .tree li').hide();
        $(details+' .tree li.qtbldt ul li').hide();
        $(details+' .tree li:first').show();
    },

    /*getSectionsQuestions: function(application_id) {
        var res = null;
        $.ajax({
            url: "../../ajax/Question_ajax/GetSectionsQuestions",
            type: 'POST',
            data: {'application_id': application_id},
            dataType: 'json',
            async: false,
            success: function(result){
                res = result;
            },
            error: function(){
                
            },
        });
        
        return res;
    },*/

    initQuestTable: function(parentId, appl, sect) {
        //var app = this.data[appl];
        var sec = this.sectionData[sect]; //app.sections[sect];
        var questions = sec.questions;

        var htm = '<table id="questions-'+sec.id+'" class="table table-striped table-bordered" cellspacing="0" width="100%">\
            <thead>\
                <tr>\
                    <th>Question Id</th>\
                    <th>Name</th>\
                    <th>Handler</th>\
                    <th>Parameters</th>\
                    <th>Score</th>\
                    <th>Weight</th>\
                    <th class="question">Question</th>\
                    <th class="answer">Answer</th>\
                    <th>Killlevel</th>\
                    <th>Status</th>\
                </tr>\
            </thead>\
            <tfoot>\
                <tr>\
                    <th class="filter_small">Question Id</th>\
                    <th class="filter">Name</th>\
                    <th class="filter">Handler</th>\
                    <th class="filter">Parameters</th>\
                    <th class="filter_small">Score</th>\
                    <th class="filter_small">Weight</th>\
                    <th class="filter">Question</th>\
                    <th class="filter">Answer</th>\
                    <th class="filter">Killlevel</th>\
                    <th class="filter_small">Status</th>\
                </tr>\
            </tfoot>\
            <tbody>\
            </tbody>\
        </table>\
        ';

        $('#'+parentId+'>ul>li').append(htm);

        // add a text input to each footer cell
        $('#questions-'+sec.id+' tfoot th.filter').each( function () {
            var title = $(this).text();
            $(this).html( '<input style="width: 87px;" type="text" placeholder="'+title+'" />' );
        } );
        $('#questions-'+sec.id+' tfoot th.filter_small').each( function () {
            var title = $(this).text();
            $(this).html( '<input style="width: 40px;" type="text" placeholder="'+title+'" />' );
        } );
        
        var killlevel_arr = [];
        killlevel_arr[0] = 'All Good';
        killlevel_arr[1] = 'Kill Self';
        killlevel_arr[2] = 'Kill Section';
        killlevel_arr[3] = 'Kill Template';
        
        var qesTable = $('#questions-'+sec.id).DataTable( {
            "columnDefs": [
                { targets: [ 0 ], "searchable": true, "orderable": true, "visible": true },
                { targets: [ 1 ], "searchable": true, "orderable": true, "visible": true },
                { targets: [ 2 ], "searchable": true, "orderable": true, "visible": true },
                { targets: [ 3 ], "searchable": true, "orderable": true, "visible": true },
                { targets: [ 4 ], "searchable": true, "orderable": true, "visible": true },
                { targets: [ 5 ], "searchable": true, "orderable": true, "visible": true },
                { targets: [ 6 ], "searchable": true, "orderable": true, "visible": true },
                { targets: [ 7 ], "searchable": true, "orderable": true, "visible": true },
                { targets: [ 8 ], "searchable": true, "orderable": true, "visible": true },
                { targets: [ 9 ], "searchable": true, "orderable": true, "visible": true }
            ],
            "order": [[ 2, "asc"]],
            "aaData": sec.questions,
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
            "aoColumns": [
                { "mDataProp": "id" },
                { "mDataProp": "name" },
                { "mDataProp": "handler" },
                { "mDataProp": "parameters" },
                { "mDataProp": "score" },
                { "mDataProp": "weight" },
                { "mDataProp": "question" },
                { "mDataProp": "answer" },
                { "mDataProp": "killlevel" },
                { "mDataProp": "status" }
            ],
            "createdRow": function ( row, data, index ) {
                var qid = $('td', row).eq(0).text();
                var inp = '<textarea>'+$('td', row).eq(6).text()+'</textarea>';
                $('td', row).eq(6).html(inp);
                var inp = '<textarea>'+$('td', row).eq(7).text()+'</textarea>';
                $('td', row).eq(7).html(inp);
                var kv = $('td', row).eq(8).text();
                var inp = killlevel_arr[kv];
                var checked0 = kv == 0 ? 'checked="checked"' : '';
                var checked1 = kv == 1 ? 'checked="checked"' : '';
                var checked2 = kv == 2 ? 'checked="checked"' : '';
                var checked3 = kv == 3 ? 'checked="checked"' : '';
                
                ht = '<div id="killlevel_label_div_'+qid+'">\
                    <a id="killlevel_label_'+qid+'" class="" href="javascript:void(0);" onclick="show_killlevel_div(\''+qid+'\')">\
                        '+inp+'\
                    </a>\
                </div>\
                <div id="killlevel_field_div_'+qid+'" style="display: none;  float: left;">';
                    ht += '<input type="radio" name="killlevel_field_'+qid+'" id="'+killlevel_arr[0]+'" value="0" '+checked0+' />&nbsp;'+killlevel_arr[0]+'<br />';
                    ht += '<input type="radio" name="killlevel_field_'+qid+'" id="'+killlevel_arr[1]+'" value="1" '+checked1+' />&nbsp;'+killlevel_arr[1]+'<br />';
                    ht += '<input type="radio" name="killlevel_field_'+qid+'" id="'+killlevel_arr[2]+'" value="2" '+checked2+' />&nbsp;'+killlevel_arr[2]+'<br />';
                    ht += '<input type="radio" name="killlevel_field_'+qid+'" id="'+killlevel_arr[3]+'" value="3" '+checked3+' />&nbsp;'+killlevel_arr[3]+'<br />';
                    ht += '<div style="clear: both; float: right;">\
                        <a href="javascript:void(0);" onclick="save_killlevel(\''+qid+'\', this)"><img class="save_cancel_img" src="<?php echo base_url()?>assets/images/save-icon.png" /></a>\
                        <a href="javascript:void(0);" onclick="cancel_killlevel_div(\''+qid+'\')"><img class="save_cancel_img" src="<?php echo base_url()?>assets/images/cancel-icon.png" /></a>\
                    </div>\
                </div>';
                $('td', row).eq(8).html(ht);
            }
        } );
     
        // apply the search
        qesTable.columns().every( function () {
            var that = this;
     
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that.search( this.value ).draw();
                }
            } );
        } );

        // Bind event to the first column
        $('td:first', '#questions-'+sec.id+' tbody tr').css("cursor", "pointer");
        $('td:first', '#questions-'+sec.id+' tbody tr').on( 'click', function () {
            window.location.href = AppTreeView.siteUrl+"/applications/question/"+qesTable.cell( this ).data();
        } );
    },


    resetQuestTable: function(parentId, appl, sect) {
        //var sec = this.data[appl].sections[sect];
        var sec = this.sectionData[sect];
        $('#questions-'+sec.id).DataTable().destroy();
        $('#'+parentId+'>ul>li').html('');
    }
}

function show_killlevel_div(qid)
{
    $("#killlevel_label_div_"+qid).css("display", "none");
    $("#killlevel_field_div_"+qid).css("display", "block");
}

function cancel_killlevel_div(qid)
{
    $("#killlevel_label_div_"+qid).css("display", "block");
    $("#killlevel_field_div_"+qid).css("display", "none");
}

function save_killlevel(qid, ths)
{
    var killlevel = $("input[name='killlevel_field_"+qid+"']:checked").val();
    var killlevel_label = $("input[name='killlevel_field_"+qid+"']:checked").attr('id');

    var values = "var values = {'killlevel': '" + killlevel + "', 'qid': '" + qid + "'};";
    eval(values);
    $.ajax({
        url: '<?php echo base_url();?>index.php/ajax/Question_ajax/SaveKillevel',
        type: 'POST',
        data: values,
        dataType: 'json',
        async: false,
        success: function(result){
            console.log(result);
            if (result.response !== false ) {
                $("#killlevel_label_"+qid).html(killlevel_label);
                //$("#killlevel_label_"+qid).attr("class", "link_normal");
                $("#killlevel_label_div_"+qid).css("display", "block");
                $("#killlevel_field_div_"+qid).css("display", "none");
            } else {
                alert('Failed to save');
            }
        }
    });

}
    
AppTreeView.sectionData = <?php echo $sections ?>;
//AppTreeView.data = <?php //echo $applications ?>;
AppTreeView.siteUrl = '<?php echo site_url() ?>';
</script>
