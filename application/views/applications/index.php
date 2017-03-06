<!--<pre><?php //print_r($applications) ?></pre>-->
<div class="container">
    <div class="row">
        <div class="col-md-12 pull-left">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Application List</h4>
                </div>
                <div style="padding: 10px;">
                    
                    <table id="applications" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Application Id</th>
                                <th>Application Date</th>
                                <th>Applicant Name</th>
                                <th>Template Name</th>
                                <th>Application State</th>
                                <th>Score</th>
                                <th>Product Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <!-- <tfoot style="display: table-header-group;"> -->
                        <tfoot>
                            <tr>
                                <th class="filter_small">App Id</th>
                                <th class="filter">Application Date</th>
                                <th class="filter">Applicant Name</th>
                                <th class="filter">Template Name</th>
                                <th class="filter_small">App State</th>
                                <th class="filter_small">Score</th>
                                <th class="filter">Product Name</th>                                
                                <th class="filter_small">Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="appScoreModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="min-width: 1060px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Score Details</h4>
            </div>
            <div class="modal-body">
                <p>Here details of <span class="score"></span></p>


                <div class="tree well">
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
    
    // add a text input to each footer cell
    $('#applications tfoot th.filter').each( function () {
        var title = $(this).text();
        $(this).html( '<input style="width: 140px;" type="text" placeholder="'+title+'" />' );
    } );
    
    $('#applications tfoot th.filter_small').each( function () {
        var title = $(this).text();
        $(this).html( '<input style="width: 100px;" type="text" placeholder="'+title+'" />' );
    } );
    

    var appTable = $('#applications').DataTable( {
       // colReorder: {
       //      order: [ 6, 5, 4, 3, 2, 1, 0 ]
       // },
        "columnDefs": [
            { targets: [ 0 ], "searchable": true, "orderable": true, "visible": true },
            { targets: [ 1 ], "searchable": true, "orderable": true, "visible": true },
            { targets: [ 2 ], "searchable": true, "orderable": true, "visible": true },
            { targets: [ 3 ], "searchable": true, "orderable": true, "visible": true },
            { targets: [ 4 ], "searchable": true, "orderable": true, "visible": true },
            { targets: [ 5 ], "searchable": true, "orderable": true, "visible": true },
            { targets: [ 6 ], "searchable": true, "orderable": true, "visible": true },
            { targets: [ 7 ], "searchable": true, "orderable": true, "visible": true }
        ],
        "order": [[ 2, "asc"]],
        "aaData": <?php echo $applications ?>,
        "aoColumns": [
            { "mDataProp": "application_id" },
            { "mDataProp": "application_date" },
            { "mDataProp": "applicant_name" },
            { "mDataProp": "template_name" },
            { "mDataProp": "application_state" },
            { "mDataProp": "score" },
            { "mDataProp": "product_name" },
            { "mDataProp": "status" }
        ]
    } );


    // Apply the search
    appTable.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        } );
    } );


    // Bind event to the first column for modal popup
    $('td:first', '#applications tbody tr').on( 'click', function () {
        window.location.href = "<?php echo site_url() ?>/applications/applicant/"+appTable.cell( this ).data();
    } );


    // Bind event to the last column for modal popup
    $('td:nth-child(6)', '#applications tbody tr').on( 'click', function () {
        var row_application_id = appTable.cell( $(this).parent().children(":nth-child(1)") ).data();
        var appScore = appTable.cell( this ).data();
        
        var tc = AppTreeView.build(row_application_id);

        $('.modal-body .score', '#appScoreModal').html( appScore );
        $('.modal-body div.tree', '#appScoreModal').html( tc );
        $('#appScoreModal').modal();

        AppTreeView.init('#appScoreModal');
        
        // reset before modal close
        $('#appScoreModal').on('hide.bs.modal', function () {
            // $('#appScoreModal .tree li:has(ul)').find(' > span > i').removeClass('glyphicon-minus-sign').addClass('glyphicon-plus-sign');
            // $('#appScoreModal .tree li.parent_li > span').off('click');
            $('#appScoreModal div.tree *').off();
            $('.modal-body div.tree', '#appScoreModal').html( '' );
        });
    } );
    
    $('td:nth-child(7)', '#applications tbody tr').on( 'click', function () {
        var row_application_id = appTable.cell( $(this).parent().children(":nth-child(1)") ).data();
        window.location.href = "<?php echo site_url() ?>/applications/checklist/"+row_application_id;
    } );
    
    $('td:nth-child(1)', '#applications tbody tr').css('cursor', 'pointer');
    $('td:nth-child(6)', '#applications tbody tr').css('cursor', 'pointer');
    $('td:nth-child(7)', '#applications tbody tr').css('cursor', 'pointer');

});

var AppTreeView = AppTreeView || {

    data: [],
    siteUrl: '',

    build: function(row_application_id) {
        var htm = '';
        var a = 0;
        var appsNum = this.data.length;

        while (a < appsNum) {
            if (this.data[a].application_id == row_application_id)  break;
            a++;
        }
        // if not match
        if (a >= appsNum)   return htm;
        
        var app = this.data[a];
        //console.log(app.application_id);
        var sections = AppTreeView.getSectionsQuestions(app.application_id);

        if (sections.length) {
            var secsNum = sections.length;
            for (var s = 0; s < secsNum; s++) {
                htm += '<li id="qtbldt-'+a+'-'+s+'">    <span><i class="glyphicon glyphicon-plus-sign"></i> '+sections[s].name+' &nbsp;&nbsp;&nbsp;Weight '+sections[s].weight+'% &nbsp;&nbsp;&nbsp;Score '+sections[s].score+'</span> \
                            <ul>';

                if (sections[s].questions.length) {
                    var quesData = sections[s].questions;
                    var quesNum = quesData.length;
                    for (var q = 0; q < quesNum; q++) {
                        htm += '<li style="cursor: pointer; display: none;" onclick="AppTreeView.goToQuesDetails(\''+quesData[q].id+'\')">    <span title="Click to go to details page"> '+quesData[q].name+' &nbsp;&nbsp;&nbsp;Weight '+quesData[q].weight+'% &nbsp;&nbsp;&nbsp;Score '+quesData[q].score+'</span></li>';
                    }
                } 

                htm += '    </li>\
                        </ul>\
                    </li>\
                    ';
            }

            htm =  '<ul>\
                        <li> <span><i class="glyphicon glyphicon-minus-sign"></i> '+app.applicant_name+' &nbsp;&nbsp;&nbsp;Score: '+app.score+'</span>\
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


    init: function(modal) {
        $(modal+' .tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Expand this branch');

        $(modal+' .tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
                
                // destroy datatables of questions
                /*if ($(this).parent().hasClass('qtbldt') && $(this).parent().has('table')) {
                    var idData = $(this).parent().attr('id').split('-');
                    if (idData.length > 2) {
                        AppTreeView.resetQuestTable($(this).parent().attr('id'), idData[1], idData[2]);
                    }
                }*/
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
                
                // insert datatables for question
                /*if ($(this).parent().hasClass('qtbldt')) {
                    var idData = $(this).parent().attr('id').split('-');
                    if (idData.length > 2) {
                        AppTreeView.initQuestTable($(this).parent().attr('id'), idData[1], idData[2]);
                    }
                }*/
            }
            e.stopPropagation();
        });

        //$(modal+' .tree li').hide();
        $(modal+' .tree li.qtbldt ul li').hide();
        $(modal+' .tree li:first').show();
    },

    goToQuesDetails: function (id) {
        window.location.href = "<?php echo site_url() ?>/applications/question/"+id;
    },
    
    getSectionsQuestions: function(application_id) {
        var res = null;
        $.ajax({
            url: "../ajax/Question_ajax/GetSectionsQuestions",
            type: 'POST',
            data: {application_id: application_id},
            dataType: 'json',
            async: false,
            success: function(result){
                res = result;
            },
            error: function(){
            },
        });
        
        return res;
    }
    /*initQuestTable: function(parentId, appl, sect) {
        var app = this.data[appl];
        var sec = app.sections[sect];
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
                    <th class="filter">Question</th>\
                    <th class="filter">Answer</th>\
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
            $(this).html( '<input style="width: 93px;" type="text" placeholder="'+title+'" />' );
        } );
        $('#questions-'+sec.id+' tfoot th.filter_small').each( function () {
            var title = $(this).text();
            $(this).html( '<input style="width: 50px;" type="text" placeholder="'+title+'" />' );
        } );


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
                { targets: [ 8 ], "searchable": true, "orderable": true, "visible": true }
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
                { "mDataProp": "status" }
            ],
            "createdRow": function ( row, data, index ) {
                var inp = '<textarea>'+$('td', row).eq(6).text()+'</textarea>';
                $('td', row).eq(6).html(inp);
                var inp = '<textarea>'+$('td', row).eq(7).text()+'</textarea>';
                $('td', row).eq(7).html(inp);
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

        // Bind event to the first column for modal popup
        $('td:first', '#questions-'+sec.id+' tbody tr').on( 'click', function () {
            window.location.href = AppTreeView.siteUrl+"/applications/question/"+qesTable.cell( this ).data();
        } );
    },


    resetQuestTable: function(parentId, appl, sect) {
        var sec = this.data[appl].sections[sect];
        $('#questions-'+sec.id).DataTable().destroy();
        $('#'+parentId+'>ul>li').html('');
    }*/
}

AppTreeView.data = <?php echo $applications ?>;
AppTreeView.siteUrl = '<?php echo site_url() ?>';
</script>
