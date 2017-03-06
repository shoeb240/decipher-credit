var entries = function () {


    function bindBasicActions() {
        $('.select-all').live('click', function () {
            if ($(this).is(':checked')) {
                $('.select-item').attr('checked', true)
            } else {
                $('.select-item').attr('checked', false)                
            }

        });

        $('.select-item').live('click', function () {
            if ($('.select-item').not(':checked').length == 0) {
                $('.select-all').attr('checked', true)
            }else {
                $('.select-all').removeAttr('checked')
            }
        });
    }

    function bindTableRows() {
        $('.entries-table tr.tbl-body:even').addClass("even");
        $('.entries-table tr.tbl-body:odd').addClass("odd");

    }


    function init() {
        bindBasicActions();
        bindTableRows();
    }

    return {
        init: init
    }
} ();