var formsregister = function () {

    function bindFileActions() {
		$('.delete-file-link').live('click', function(){
			var domid = $(this).attr('data-domid')
			
			var fileNameField = $(".file-name-field-" + domid);
			var fileField = $(".file-picker-field-" + domid);
			var container = $(this).closest('ul');
			
			fileField.removeClass("hide");
			fileNameField.val('');
			container.hide();
		});
    }

    function init() {
        bindFileActions();        
    }

    return {
        init: init
    }
} ();