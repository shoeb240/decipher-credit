var global = function () {

    function bindGlobals() {

        // bind lightboxes
        $U.bindLightboxes();

        // bind the tooltip items
        $U.bindTipsies();

        // preload images using image paths loaded in a span with class
        // "preaload-path"
        $('.preload-path').each(function (index, item) {
            var img = new Image();
            img.src = $(item).text();
        });

        // bind watermarked input fields
        $U.bindWatermarks();

        // bind elastics
        $U.bindElastics();

        // bind link submits
        $U.bindLinkButtonSubmit();

        // bind characters-left counter
        $U.bindTextAreaMax();

        // bind popup windows
        $U.bindPopups();

        // ajax action links
        $U.bindAjaxActionLinks();

        // bind redirect buttongs
        $U.bindRedirectButton();

        // bind More/less
        $U.bindMoreLess();

        // prevent enter submit on some fields
        $U.preventEnterSubmit();

        //submits checkbox form after checking
        $U.bindCheckboxSubmit();

        // prevent double form submit
        $U.preventDoubleFormSubmit();

        // restrict numeric input elements
        $U.bindNumerics();
		
		$U.bindStepper();
		
		// bind input mask
		$U.bindInputMasks();


        $('input.select').live('click', function () {
            $(this).select();
        });

        $('input.formatted-currency-field').live('blur', function () {
            try {
                if ($(this).val().length > 0) {
                    $(this).val(parseFloat($(this).val()).toFixed(2));
                }
            } catch (e) {

            }
        });
		
		// bind datepickers
		$('li[data-control-type="datepicker"]').each(function(index,item){
			var domId = $(item).attr('data-dom-id');			
			$U.bindFormDatePickers(domId);
		});	
    }

    function getRoot() {
        return location.protocol + '//' + location.host
    }

    function setEqualHeight() {
        columns = $("div.equal-height-column");
        var tallestcolumn = 0;
        columns.each(
         function () {
             currentHeight = $(this).height();
             if (currentHeight > tallestcolumn) {
                 tallestcolumn = currentHeight;
             }
         }
        );
        columns.css('min-height', tallestcolumn);
    }


    function getItemId(item) {
        return item.attr('data-item-id');
    }


    function modalAjaxCallback() {
        $U.log('modal callback')
        if ($('#is-modal-ajax-succesful')) {
            if ($('#is-modal-ajax-succesful').val() == "true") {
                var message = $('#modal-ajax-message').val();
                $U.writeMessageAndCloseLightbox(message);
            }
        }
    }
	
	function loadUpdatedVersionModal(){	
		 
		 // handle view new features
		 $('.view-new-features').live('click', function(){
			 
			 $.modal($('#version-two-script').tmpl([{contextcssclass: 'view-feature-list'}]), {
                minWidth: 200,
				overlayId: 'overlay',
				containerId: 'container',
				escClose: true,
				overlayClose: true,                
                onShow: function (dialog) { 					 
						
					}
				}); 
			 
		 });
	}
	
	function bindUpdateTemplatesLink(){
		$('#update-templates-button').live('click', function(e){			
			e.preventDefault();
			var link = $(this).attr('data-update-templates-link');		
			var loaderHtml = "<div class='preloader'><img src='content/images/spinner.gif' alt='preloader' />Updating Templates...</div>";
			if ($('.simplemodal-container').length > 0)
			{
				var modalWrap = $('.simplemodal-container');				
				modalWrap.html(loaderHtml);
				$(".simplemodal-container")
				.css('height', 'auto')
				.css('width', 'auto'); 
				
				$(window).trigger('resize.simplemodal');           //To refresh the modal dialog.
			    updateTemplates(link);
			}else{
				$.modal(loaderHtml, {
                minWidth: 50,
				overlayId: 'overlay',
				escClose: false,
				overlayClose: false,                
                onShow: function (dialog) { 					 
						updateTemplates(link);						
					}
				});
				
			}
			 
		});
	}
	
	function bindCopyFormLink(){
		$('.copy-form-link').live('click', function(e){			
			e.preventDefault();
			var link = $(this).attr('data-copy-link');		
			var loaderHtml = "<div class='preloader'><img src='content/images/spinner.gif' alt='preloader' />copying form...</div>";
			if ($('.simplemodal-container').length > 0)
			{
				var modalWrap = $('.simplemodal-container');				
				modalWrap.html(loaderHtml);
				$(".simplemodal-container")
				.css('height', 'auto')
				.css('width', 'auto'); 
				
				$(window).trigger('resize.simplemodal');           //To refresh the modal dialog.
			    copyForm(link);
			}else{
				$.modal(loaderHtml, {
                minWidth: 50,
				overlayId: 'overlay',
				escClose: false,
				overlayClose: false,                
                onShow: function (dialog) { 					 
						copyForm(link);						
					}
				});
				
			}
			 
		});
	}
	
	function bindAddFormButton(){
		//<?php echo $docRoot; ?>/actions.php?a=create
		$('#add-form-button').live('click', function(e){			
			e.preventDefault();
			var templateList = $('#templates');
			var templateid = templateList.val();						
			var createLink = templateList.attr('data-create-link');
			
			if (templateid == "-1"){
				window.location = createLink;
				return false;
			}
			
			var copyLink = templateList.attr('data-copy-link');
			var link = copyLink + "&id=" + templateid + '&uses-template=true';
			
			var loaderHtml = "<div class='preloader'><img src='content/images/spinner.gif' alt='preloader' />copying template...</div>";
			if ($('.simplemodal-container').length > 0)
			{
				var modalWrap = $('.simplemodal-container');				
				modalWrap.html(loaderHtml);
				$(".simplemodal-container")
				.css('height', 'auto')
				.css('width', 'auto'); 
				
				$(window).trigger('resize.simplemodal');           //To refresh the modal dialog.
			    copyForm(link);
			}else{
				$.modal(loaderHtml, {
                minWidth: 50,
				overlayId: 'overlay',
				escClose: false,
				overlayClose: false,                
                onShow: function (dialog) { 					 
						copyForm(link);						
					}
				});
				
			}
			 
		});
	}
	
	function copyForm(link){
		$.get(link, null, function(result){						
						if (result.success == true){
							window.location = result.url;
						}else{
							alert(result.message);
						}
							
		});
	}
	
	function updateTemplates(link){
		$.get(link, null, function(result){						
			if (result.success == true){
				window.location = result.url;
			}else{
				alert(result.message);
			}
				
		});
	}
	
	function bindTemplatize() {
        $('#templatize').live('click', function () {
			var active = $(this).is(':checked') ? "true" : "false";
			var formid = $(this).attr('data-formid');
            $.get('actions.php?a=update-template&XDEBUG_SESSION_START=1&enable=' + active + '&id=' + formid, null, function(result){
				if (result){	
					console.log(result);
					if (result.success){
						
					}else{
						alert('unable to toggle template setting');
					}
					
				}else{
					alert('unable to toggle template setting');
				}
			});
        });
    }


    function init() {
        bindGlobals();
        setEqualHeight();
		bindCopyFormLink();
		loadUpdatedVersionModal();
		bindTemplatize();
		bindAddFormButton();
		bindUpdateTemplatesLink();
    }

    return {
        init: init,
        getRoot: getRoot,
        getItemId: getItemId,
        modalAjaxCallback: modalAjaxCallback
    }

} ();


try {
    // do not show error if this fails, not mission-critical
    $.validator.addMethod("zipcode", function (postalcode, element) {
        //removes placeholder from string
        postalcode = postalcode.split("_").join("");

        //Checks the length of the zipcode now that placeholder characters are removed.
        if (postalcode.length === 6) {
            //Removes hyphen
            postalcode = postalcode.replace("-", "");
        }
        //validates postalcode.
        return this.optional(element) || postalcode.match(/^\d{5}$|^\d{5}\-\d{4}$/);
    }, "Please specify a valid zip code");

} catch (ex) {

}





