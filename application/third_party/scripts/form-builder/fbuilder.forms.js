var forms = function () {

    var dropPosition = 0;
    var activeItemId = 0;
    var activeControl = 'form';
    var append = false;
    var inSort = false;
	var fieldAttributeDictionary = $('#field-attribute-dictionary').length > 0 ? $.parseJSON(decodeURIComponent($('#field-attribute-dictionary').val())) : {};
	var defaultFieldJSONEncoded = $('#field-json-object').length > 0 ? $('#field-json-object').val() : "";
	var defaultFieldJSONDecoded = decodeURIComponent(defaultFieldJSONEncoded);
	var defaultFieldJSONObject = $.parseJSON(defaultFieldJSONDecoded);
    function bindBasicActions() {

        // bind tools menu togglers
        $('.menu-toggle').click(function () {
            var link = $(this)
            var idParts = link.attr("id").split("-");
            var toToggle = $('#' + idParts[0] + '-' + idParts[1] + '-list');

            if (toToggle.is(':visible')) {
                toToggle.slideUp(function () {
                    link.find('span')
                        .addClass('menu-toggle-down-icon')
                        .removeClass('menu-toggle-up-icon')
                });
            } else {
                toToggle.slideDown(function () {
                    link.find('span')
                        .addClass('menu-toggle-up-icon')
                        .removeClass('menu-toggle-down-icon')
                });
            }
        });
                
        // delete action
        $('.delete-field-icon').live('click', function () {					
			if (confirm("Are you sure you'd like to delete this field? All entries for this field will be lost.")) {
				$('#field-property-container').hide();
				$("#form-property-container").show();
				toggleSaveButton();
				autoDeleteField = false;
				doDeleteField($(this));
			}
			
        });

        // active action
        $('li.drop-item, .editable').live('click', function () {
            var parentItem = $(this).closest('li.drop-item');
            activateField(parentItem);

        });

        // list item hover
        $('li.drop-item').live({
            mouseenter:
         function () {
             $(this).find('.hidden-icon').removeClass('hide');
         },
            mouseleave:
         function () {
             $(this).find('.hidden-icon').addClass('hide');
         }
        });

        // make form title editable
        $('.form-editable').live('click', function () {
            activeItemId = '0';
            loadProperties();
        })

        // wire up cancel event for upgrade
        $('.close-locked-form-link').live('click', closeLockedFormModal);

    } // end basic actions

    function doDeleteField(target) {
        target.closest('li.drop-item').slideUp('fast', function () {

            var domId = $(this).attr('data-dom-id'),
                evtId = $('#EventId').val(),
                propsField = $(this).find('#field-prop-' + domId);				
				fieldId = $(propsField).attr('data-field-id'),
				controltype = $(this).attr('data-control-type');

            $(this).remove();				
            if (fieldId) {								
				$.post('actions.php?a=deletefield', { eventid: evtId, fieldid: fieldId }, function (response) {					
					if (response.success == true){
						updateWizardStepsForAllControls();
						refreshForm();							
					}else{
						alert(response.message);
					}
				});
            }
        })
    }


	function closeModal() {
        $.modal.close();        
    }

    function bindDragAndDrop() {
        $('.form-tool').draggable({
            helper: draggableElement,
            snap: "#drop-form",
            start: startToolDrag

        });

        $('#drop-form').droppable({
            activate: handleActivate,
            over: handleOver,
            drop: handleDrop,
            out: handleOut,
            hoverClass: 'drop-form-hover',
            activeClass: 'drop-form-hover'

        });
    }
	
	function bindClickToAdd(){
		$('.fm-click-to-add').live('click',function(){            
			dropItemOnForm($(this).closest('.form-tool'), false);
        });
	}

    function startToolDrag(event, ui) {
        inSort = false;
    }

    function handleOver(event, ui) {		
        append = true;
        removeGuide();
    }

    function handleOut(event, ui) {
        removeGuide();
    }

    function handleActivate(event, ui) {

    }

    function handleDrop(event, ui) {
        if (!inSort) {
            if (ui.offset.left >= 300 || $('li.guido').length > 0) {
                dropItemOnForm($(ui.draggable),true);
            }
        }
    }
	
	function dropItemOnForm(item, isDragAction){
		// get item properties
		var controlType = $(item).attr('data-type');
        var isAvailable = true;
		var isSingleInstance = $(item).attr('data-is-single-instance') && $(item).attr('data-is-single-instance').toLowerCase() == 'true';
		
		// if item is single-instance
		if(isSingleInstance){
			if($('#drop-form').find('[data-control-type="' + controlType + '"]').length > 0){
				handleSingleInstancePermitted(item);
				return;
			}
		}
		// and instance already exists on the drop form
		// pop-up a message
		// exit the sequence
		
		// if this current item being dragged
		var dropPos = getDropPos();
		var newItem = generateItem(controlType, dropPos, isAvailable);
		
		// remove previously active item
		$('li.drop-item').removeClass('prev-active');
		if ($('li.active').length > 0){			
			$('li.active').addClass('prev-active');
		}	
		$('li.drop-item').removeClass('active');
			
		if(isDragAction){
			// Drag N' Drop being used
			
			if ($('.drop-item').length == 0 || append == true) { 
				$('#drop-form').append(newItem);
			} else {
				var selector = "li.drop-item:eq(" + (dropPos - 1) + ")"
				$(selector).before(newItem);
			}
		}else{
			// double click being used
			if($('.drop-item').length == 0 ){  // handles case where first item being added
				$('#drop-form').append(newItem);
			}else{
			    var lastItem = $('li.drop-item').last();								
			    if ($('.prev-active').length > 0){
					$('.prev-active').after(newItem)
				}else{
					lastItem.after(newItem);
				}
				
				
			}
		}

		refreshForm();
		$U.highlight(newItem);		
		loadProperties();
		removeGuide();
		bindDroppableItems();
		bindSettingsActions(newItem);
		refreshSortOrder();
		updateWizardStepsForAllControls();
		bindEditables();
		toggleSaveButton();		
		handleLockedFormEdit();		
	}
	
	// Demo only
	function handleLockedFormEdit(disableautodelete) {
        setTimeout(function () {
            var isLocked = $('#drop-form').hasClass('is-locked');            
            if (isLocked){				
                autoDeleteField = disableautodelete && disableautodelete === false ? false : true;
                $.modal($('#is-locked-form-template').tmpl(), {
                    overlayId: 'overlay',
                    containerId: 'container',
                    closeHTML: null,
                    minHeight: 80,
                    opacity: 65,                    
                    overlayClose: false,
					escClose: false,
					onClose: closeLockedFormModal
                });
            }
        }, 500);
    }
	
	// demo only
	function closeLockedFormModal() {
        $.modal.close();
        var deleteIcon = $('#drop-form').find('li.active').find('.delete-field-icon');
		if (autoDeleteField==true){
			doDeleteField(deleteIcon);
		}
    }
	
	function handleSingleInstancePermitted(item) {
		
        $.modal($('#single-instance-permitted-template').tmpl([{controlType: $(item).attr('data-type')}]), {
                    overlayId: 'overlay',
                    containerId: 'container',
                    closeHTML: null,
                    minHeight: 80,
                    opacity: 65,                    
                    overlayClose: true                    
                } );
    }

    function toggleSaveButton() {
        if ($('li.drop-item').length > 0) {
            $('#submit-button-list').show();
        } else {
            $('#submit-button-list').hide();
        }
    }

    function draggableElement() {
        return $('<div>' + $(this).html() + '</div>');

    }

    function bindDroppableItems() {

        $('.drop-item').droppable({
            over: handleItemOver
        });
    }

    function handleItemOver(event, ui) {
        if (!inSort) {
            append = false;
            dropPosition = $('.drop-item').index($(this));
            $("ul#drop-form li.drop-item:nth-child(" + (getDropPos()) + ")").before(guideElement());
        }
    }

    function bindSettingsActions(obj) {

    }

    function guideElement() {
        // remove previous guides
        removeGuide();

        // return new guides
        return $("<li id='guide-item' class='guido'></li>");
    }

    function getDropPos() {
        return dropPosition + 1;
    }

    function generateItem(controltype, orderId, isAvailable) {
        var availability = (isAvailable) ? "available" : "unavailable";
        var uniqueId = parseInt($('li.drop-item').length + 1);
        var uniqueIdStr = 'drop-item-' + uniqueId;
        var isIdUnique = $('#' + uniqueIdStr).length == 0;

        while (!isIdUnique) {
            uniqueId++;
            uniqueIdStr = 'drop-item-' + uniqueId;
            isIdUnique = $('#' + uniqueIdStr).length == 0;
        }

        activeItemId = uniqueId;
        activeControl = controltype.toLowerCase();

		// update properties in default json object and then assign
		var jsonObject = defaultFieldJSONObject;
		updateJSONObject(uniqueId, 'domid', uniqueId, jsonObject);  
		updateJSONObject(uniqueId, 'order', orderId, jsonObject);  
		updateJSONObject(uniqueId, 'fieldtype', activeControl, jsonObject);  
		jsonobjectstring = encodeURIComponent(JSON.stringify(jsonObject));
		
        var templateData = [
            { id: uniqueId, domid: uniqueId, order: orderId, fieldType: activeControl, jsonObject: jsonobjectstring, isavailable: isAvailable }
        ];

        var listItem = $('<li id="' + uniqueIdStr + '" class="drop-item active ' + activeControl +  '-control ' + availability + '" data-control-type="' + activeControl + '" data-dom-id="' + uniqueId + '"></li>')
        var templateName = 'form-field-' + activeControl + '-template';
        var renderedTemplate = $('#' + templateName).tmpl(templateData);
        listItem.append(renderedTemplate);		
        return listItem;

    }

    function removeGuide() {
        $('.guido').remove();
    }

    function loadProperties() {
        if (activeItemId == 0) {
            $('#field-property-container').hide();
            $('#form-property-container').show();
        } else {
            $('#field-property-container').show();
            $('#form-property-container').hide();
           
            // show applicable properties
            $('#field-property-table').find('tr').not('.hide').show();
            $('#field-property-table').find('tr').not('.' + activeControl).hide();			
			$('#field-property-table').find('tr.all-fields').show();		
			
			//setup "subscriber channel" properties            
            assignSettingValues(activeControl);            
            bindDependentFields();
			initializeDatePickers(activeItemId);			
			 
            // console.log(getFieldJSONObject(activeItemId));

        }
    }

    function assignSettingValues(activeControl) {
		var settingFields = $('#field-property-table').find('.' + activeControl + ',.all-fields').find('input,select,textarea');        
        settingFields.removeAttr('data-sub-channel')
        settingFields.each(function (index, item) {
            var fieldPropertyType = $(item).attr('data-field-property');
            if (fieldPropertyType) {
                var newSubChannel = 'sub-' + fieldPropertyType + '-' + activeItemId;
                var currHiddenValId = fieldPropertyType + '-prop-' + activeItemId;
				
                $(item).attr('data-sub-channel', newSubChannel);  // change the subscription channel				
				//console.log('activeitemid: ' + activeItemId + '\nProperty type:' + fieldPropertyType + '\nProperty Value:' + fieldValue);
				var jsonObject = getFieldJSONObject(activeItemId);  // retrieve and set the json property
				var fieldValue = getFieldJSONObjectValue(jsonObject, fieldPropertyType);
				//console.log('activeitemid: ' + activeItemId + '\nProperty type:' + fieldPropertyType + '\nProperty Value:' + fieldValue);				
				$(item).val(fieldValue);
				
            }
        });
		
		bindDependentFields();
    }

    function bindSortable() {
        // bind sortable drop form
        $('#drop-form').sortable({
            handle: '.drag-icon',
            placeholder: 'place-holder',
            start: startSort,
            update: updateSort
        });
    }

    function updateSort(event, ui) {
        inSort = false;
        refreshSortOrder();
		updateWizardStepsForAllControls();
    }

    function startSort(event, ui) {
        inSort = true;
    }

    function refreshSortOrder() {
        $('ul#drop-form').find('li.drop-item').each(function (index, item) {
            var domId = $(item).attr('data-dom-id');            
			updateJSONObject(domId, 'order', index);

        });
    }
	
	function updateWizardStepsForAllControls(){
		var numberOfSteps = $('li[data-control-type=formbreak]').length;
		console.log('Number of steps is ' + numberOfSteps);
		if(numberOfSteps == 0){
			$('li.drop-item').each(function(index,item){
				var domId = $(item).attr('data-dom-id');	
				updateJSONObject(domId, 'wizardstep', 1);					
			});
		}else{
		
			$('li[data-control-type=formbreak]').each(function(index,item){			
				//console.log(item)
				var itemDomId = $(item).attr('data-dom-id');
				
				// update the actual wizard buttons control
				updateJSONObject(itemDomId, 'wizardstep', index+1);					
				var previousControlListItems = $(item).prevUntil('li.formbreak-control');
				
				// update the step on all controls above it
				previousControlListItems.each(function(i,prevItem){		
				  //  console.log(prevItem);			
					var domId = $(prevItem).attr('data-dom-id');			
					if(domId){
						updateJSONObject(domId, 'wizardstep', index+1);					
					}
				});

				// check item.nextUntil(formbreak): if there are more controls but no wizard control
				// update the wizard step for the remaining controls 
				if ($(item).nextAll('li.formbreak-control').length == 0){				
					var nextControlListItems = $(item).nextAll('li.drop-item');
				
					// update the step on all controls below it
					nextControlListItems.each(function(i,nextItem){		
						//console.log(nextItem);			
						var domId = $(nextItem).attr('data-dom-id');			
						if(domId){
							updateJSONObject(domId, 'wizardstep', numberOfSteps+1);							
						}
					});
				}
				
			});
			
			updateNextPreviousVisibilityForWizardButtons();
		}
	}
	
	function updateNextPreviousVisibilityForWizardButtons()
	{
		$('li.formbreak-control div.input')
		.removeClass('first-wizard-control')
		.removeClass('last-wizard-control');		
		
		var firstWizControl = $('li.formbreak-control').first();
		var lastWizControl = $('li.formbreak-control').last();
		var firstInputContainer = $(firstWizControl).find('div.input').first();			
		var lastInputContainer = $(lastWizControl).find('div.input').first();	
			
		// add the "first-wizard-buttons" class if it's the first buttons
		firstInputContainer.addClass('first-wizard-control');
		
		// add the "last-wizard-buttons" class if it's the last buttons
		lastInputContainer.addClass('last-wizard-control');
	}

    function bindEditables() {
        // bind editable-labels
        $('.editable').editable(updateEditableField, {
            onblur: 'submit',
            cssclass: 'ignore',
            maxlength: 40
        });

        $('.form-editable').editable(updateFormEditableField, {
            onblur: 'submit',
            cssclass: 'ignore',
            maxlength: 32
        });
		
		// $('.paragraph-editable').editable(updateEditableField, {
            // onblur: 'submit',
            // cssclass: 'ignore',
			// type: 'textarea',
            // maxlength: 500
        // });
		
		tinymce.init({
			menubar: false,
			selector: ".paragraph-editable",
			inline: true,
			width: 275,
			setup: function(editor) {
						editor.on('blur', function(e) {							
							var spanItem = $('#' + $(e.target.bodyElement).attr('id'));
							updateEditableField(spanItem.html(), null, spanItem);
						});
			},
			plugins: [
				"advlist autolink",
				"searchreplace visualblocks code anchor link",
				"insertdatetime contextmenu emoticons charmap textcolor colorpicker"
			],
			toolbar: "bold italic | forecolor | charmap emoticons | link | code"
		});

    }

    // callback function after a label/or other inline-editable field
    // has been updated
    function updateEditableField(value, settings, element) {		
		elem = typeof(element) === 'undefined' ? $(this) : element;  
        var pubId = $(elem).closest('li.drop-item').attr('data-dom-id');
		var controlType = $(elem).closest('li.drop-item').attr('data-control-type');		
        var publisherType = $(elem).get(0).tagName.toLowerCase();
        publisherType = publisherType == 'h2' ? 'text' : publisherType;
		
		if (controlType.toLowerCase() == "paragraph" ){
			publisherType = "content";
		}
		
        // if (value.length == 0 && !(controlType.toLowerCase() == "captcha" || controlType.toLowerCase() == "paragraph")) {
        //    value = "Click to edit";
        // }
        doFieldSettingUpdates(pubId, publisherType, value);
        $('#isAltered').val(1)
        return (value);
    }


    function updateFormEditableField(value, settings) {
        if (value.length == 0) {
            value = "Registration";
        }
        doFieldSettingUpdates("0", "title", value);
        $('#isAltered').val(1)
        return (value);
    }

    // assigns updated settings to hidden input fields and other targets
    // that need to be updated in realtime
    function doFieldSettingUpdates(publisherId, publisherType, valueToPublish) {
        var subIdentifier = 'sub-' + publisherType + '-' + publisherId;
        var inputSubscribers = $('input[data-sub-channel=' + subIdentifier + ']');		
        inputSubscribers.val(valueToPublish);
		
		var textAreaSubscribers = $('textarea[data-sub-channel=' + subIdentifier + ']');		
        textAreaSubscribers.val(valueToPublish);

        var labelSubscribers = $('label[data-sub-channel=' + subIdentifier + ']');
        labelSubscribers.text(valueToPublish);

        var titleSubscribers = $('h2[data-sub-channel=' + subIdentifier + ']');
        titleSubscribers.text(valueToPublish);
		
		updateJSONObject(publisherId, publisherType, valueToPublish);
		
        applyRealtimeChange(publisherId, publisherType, valueToPublish)

        //console.log(getFieldJSONObject(publisherId));
    }
	
	function updateJSONObject(objectId, objectProperty, objectValue, jsonObj){
		// Update JSON object
		var objectPropertyId = '#field-prop-' + objectId;				
		var jsonObject = typeof jsonObj !== 'undefined' ? jsonObj : getFieldJSONObject(objectId);
		
		if(jsonObject){
			setFieldJSONObjectValue(jsonObject,objectProperty,objectValue);			
			// set the field's value back to the updated JSON object
			if($(objectPropertyId).length > 0){
				var newJsonStringValue = JSON.stringify(jsonObject);				
				$(objectPropertyId).val('');
				$(objectPropertyId).val(encodeURIComponent(newJsonStringValue));		
				$('#isAltered').val(1);
			}
		}
	}
	
	function getFieldJSONObject(fieldId){
		var objectPropertyId = '#field-prop-' + fieldId;		
		
		if($(objectPropertyId).length > 0){
			var order = $(objectPropertyId).attr('data-field-order');
			var id = $(objectPropertyId).attr('data-field-id');
			var fieldType = $(objectPropertyId).attr('data-field-type');
			
			var rawObjectValue = $(objectPropertyId).val();
			var decodedObjectValue = decodeURIComponent(rawObjectValue);
			var jsonObject = $.parseJSON(decodedObjectValue);
			return jsonObject;
		}
		
		return null;
	}
	
	function getFieldJSONObjectValue(object, lCaseProperty){		
		var trueCasedProperty = getFieldJSONObjectAttribute(object, lCaseProperty);
		var value = '';
		eval('value = object.' + trueCasedProperty + ';');		
		return value;
	}
	
	function setFieldJSONObjectValue(object, lCaseProperty, value){
		var trueCasedProperty = getFieldJSONObjectAttribute(object, lCaseProperty);		
		value = lCaseProperty == "content" ? encodeURI(value.replace(/\r?\n/g, '<br/>')) : value;  // TODO: figure out option to special treatment for content
		eval('object.' + trueCasedProperty + '="' + value + '";');		
	}
	
	function getFieldJSONObjectAttribute(object, lCaseProperty){
		var trueCasedProperty = '';
		eval('trueCasedProperty=fieldAttributeDictionary.' + lCaseProperty + ';');
		return trueCasedProperty;		
	}

    function applyRealtimeChange(domId, changeType, value) {
        var targetContainer = $('#drop-item-' + domId);
        var _controlType = targetContainer.attr('data-control-type');
        switch (changeType) {
            case "isrequired":
                if (value.toLowerCase() == "true") {
                    targetContainer.find(".required").removeClass('hidden').addClass('visible');
                } else {
                    targetContainer.find(".required").removeClass('visible').addClass('hidden');
                }
                break;
            case "maxchars":
                targetContainer.find('input[type=text]').attr("maxlength", value);
                break;
            case "helptext":
                var helpIcon = targetContainer.find('.help-icon');
                helpIcon.attr("title", value);
                if (value.length > 0) {
                    helpIcon.show();
                } else {
                    helpIcon.hide();
                }
                $U.bindTipsies();
                break;
            case "hint":
                var inputField = targetContainer.find('input[type=text],textarea');
                inputField.attr("title", value);
                inputField.attr("placeholder", value);
                break;
            case "css":
                targetContainer.addClass(value);
				break;
            case "options":
                var optionsArray = (value.length > 0) ? value.split(',') : "Option 1, Option 2".split(',');

                if (_controlType == "dropdownlist") {
                    // bind options to select list   
                    var selectList = targetContainer.find('select');
                    selectList.find('option').remove();
                    $.each(optionsArray, function (index, item) {
                        selectList.append('<option value="'+ item +'">' + item + '</option');
                    });

                } else if (_controlType == "radiobutton") {
                    //bind options to radio button list
                    var optionList = targetContainer.find('.option-list');
                    optionList.find('li').remove();
                    $.each(optionsArray, function (index, item) {
                        optionList.append('<li><input type="radio" value="' + item + '" name="radiogroup-' + domId + '" /><label>' + item + '</label></li>')
                    });
                } else if (_controlType == "checkbox") {
                    // bind options to checkbox list
                    var optionList = targetContainer.find('.option-list');
                    optionList.find('li').remove();
                    $.each(optionsArray, function (index, item) {
                        optionList.append('<li><input type="checkbox" value="' + item + '" /><label>' + item + '</label></li>')
                    });
                }
                break;
            case "selectedoption":
                if (_controlType == "dropdownlist") {
                    var selectList = targetContainer.find('select');
					if(selectList.hasClass('multi-select-mode')){
						selectList.find('option').removeAttr('selected');
						selectList.find('option[value="' + value + '"]')
								  .attr('selected', true);
					}else{
						selectList.val(value);
					}
                } else if (_controlType == "radiobutton") {
				    targetContainer = $('#drop-item-' + domId + ' :input[value="' + value + '"]');
                    targetContainer.removeAttr('checked');
                    targetContainer.attr('checked', 'checked')
                }

                break;
            case "minimumage":
                var d = new Date();
                var thisYear = d.getFullYear();
                var maxAge = parseInt(targetContainer.find('#maximumage-prop-' + domId).val());
                var minAge = (parseInt(value) >= maxAge) ? maxAge - 1 : parseInt(value);
                var yearddl = targetContainer.find('.birth-year')
                yearddl.find('option').remove();

                var startYear = parseInt(thisYear - maxAge);
                var endYear = parseInt(thisYear - minAge);

                // console.log("start: " + startYear + "\n end:" + endYear + "\nminage:" + minAge + "\nmaxAge:" + maxAge);
                for (i = endYear; i >= startYear; i--) {
                    yearddl.append($('<option>' + i + '</option>'));
                }
                yearddl.prepend($('<option selected="true"></option>'));

                $('#maxAge').val(maxAge);
                $('#minAge').val(minAge);
                break;
            case "maximumage":
                var d = new Date();
                var thisYear = d.getFullYear();
                var minAge = parseInt(targetContainer.find('#minimumage-prop-' + domId).val());
                var maxAge = (parseInt(value) <= minAge) ? minAge + 1 : parseInt(value);
                var yearddl = targetContainer.find('.birth-year')
                yearddl.find('option').remove();

                var startYear = parseInt(thisYear - maxAge);
                var endYear = parseInt(thisYear - minAge);

                // console.log("start: " + startYear + "\n end:" + endYear + "\nminage:" + minAge + "\nmaxAge:" + maxAge);
                for (i = endYear; i >= startYear; i--) {
                    yearddl.append($('<option>' + i + '</option>'));
                }
                yearddl.prepend($('<option selected="true"></option>'));


                $('#maxAge').val(maxAge);
                $('#minAge').val(minAge);
                break;
			case "showprevious":
				var inputContainer = $('[data-dom-id=' + domId + ']').find('div.input').first();					
				if(value == "True"){
					inputContainer.removeClass('hide-previous');					
				}else{
					inputContainer.addClass('hide-previous');
				}
			
				break;
			case "shownext":
				var inputContainer = $('[data-dom-id=' + domId + ']').find('div.input').first();					
				if(value == "True"){
					inputContainer.removeClass('hide-next');					
				}else{
					inputContainer.addClass('hide-next');
				}				
				break;
			case "showtime":
				var inputContainer = $('#date-picker-input-' + domId);
				var listContainer = inputContainer.find('ul').first();
				if(value == "True"){
					listContainer.addClass('show-time-mode');					
				}else{
					listContainer.removeClass('show-time-mode');
				}
				
				// set time fields
				initializeTimePickers(domId);
				break;
			case "timeformat":
				var inputContainer = $('#date-picker-input-' + domId);
				var listContainer = inputContainer.find('ul').first();
				var startHour = 1;
                var endHour = 12;				
				var timeValues = getFormattedTimeValues(value);
				
				if(value == "24"){
					listContainer.addClass('twenty-four-hour-mode');
					startHour=0;
					endHour=23;
				}else{
					listContainer.removeClass('twenty-four-hour-mode');
				}
				
				// populate hour drop down list
				var hourddl = targetContainer.find('.hour');
				hourddl.find('option').remove();                                
                for (i = startHour; i <= endHour; i++) {
					var strValue = i < 10 ? "0" + i : i;
					var selectedAttribute = timeValues['hh'] == i ? ' selected="selected" ' : "";
                    hourddl.append($('<option value="'+ i +'"' + selectedAttribute + '>' + strValue + '</option>'));
                }
			
				// set time fields
				initializeTimePickers(domId, value);
				break;					
		    case "language":				
				initializeDatePickers(domId);
				break;
			case "istofromdate":
				var inputContainer = $('#date-picker-input-' + domId);
				var listContainer = inputContainer.find('ul').first();
				if(value.toLowerCase() == "true"){
					listContainer.addClass('two-date-mode');
				}else{
					listContainer.removeClass('two-date-mode');
				}
				initializeDatePickers(domId)
				break;	
			case "url":
				var imgObj = $('#field-' + domId);
				var tagName = imgObj.prop("tagName").toLowerCase();				
				if(tagName == "img"){
					imgObj.attr("src", value);
				}
				break;
			case "alttext":
				var imgObj = $('#field-' + domId);
				imgObj.attr("alt", value);
			    break;
			case "minnumber":
				var inputField = targetContainer.find('input[type=text]');
				inputField.val('');
				inputField.removeAttr('min');
				inputField.attr('min', value);
				if(inputField.closest('.stepper').length > 0){inputField.closest('.stepper').stepper('destroy');}
				inputField.stepper();
			    break;
			case "maxnumber":
				var inputField = targetContainer.find('input[type=text]');
				inputField.val('');
				inputField.removeAttr('max');
				inputField.attr('max', value);
				inputField.closest('.stepper').destroy();
				inputField.stepper();
			    break;				
			case "textmode":
				var inputField = targetContainer.find('input[type=text]');
				var inputMaskPropertyField = $('#prop-inputmassk');
				
				inputMaskPropertyField.val('Null');
				updateJSONObject(domId, 'inputmask', "");       
				
				inputField.val('');
				inputField.inputmask('remove');
				inputField.closest('.stepper').stepper('destroy');
                inputField.attr('data-textmode', value.toLowerCase());				
				//$('#prop-tr-inputmask').hide();
				
				if (value.toLowerCase() == "number"){					
					inputField.stepper();
				}else if (value.toLowerCase() == "password"){
					bindTextEncrypt();
				}else if(value.toLowerCase() == "text"){
					//$('#prop-tr-inputmask').show();	
				}
				break;
			case "inputmask":
				var inputField = targetContainer.find('input[type=text]');
				inputField.val('');
				 if (value.toLowerCase() == ""){
					 inputField.removeClass('masked-field');
					 break;
				 }		
				 
				 inputField.inputmask('remove');
				 inputField.removeData('inputmask');					 
			     $.get('actions.php?a=get-content&mask=' + value, null, function (obj) {					 
					 if (obj){
						inputField.addClass('masked-field');
						inputField.data('inputmask', obj.Mask);
						inputField.inputmask();
					 }
				 });
				break;			
			case "alignment":
			 	var obj = $('#field-' + domId);
				var objContainer = obj.closest(".form-alignable-container");
				var tagName = obj.prop("tagName").toLowerCase();
				if(tagName == "img" || tagName == "span"){
					objContainer
					.removeClass("left-align-form-element")				
					.removeClass("right-align-form-element")
					.removeClass("center-align-form-element")
					.addClass(value.toLowerCase() + "-align-form-element");
				}				
				break;
			case "optionsalignment":
			 	var control = targetContainer.find('.option-list');
				if (value == "vertical"){
					control.removeClass("horizontal-list").addClass("vertical-list");
				}else{
					control.removeClass("vertical-list").addClass("horizontal-list");
				}
				break;				
			case "multiselect":			    
				var selectControl = targetContainer.find('select').first();				
				if (value.toLowerCase() == "true"){
					selectControl.attr("multiple","true")
					selectControl.addClass("multi-select-mode");
				}else{
					selectControl.removeAttr("multiple");
					selectControl.removeClass("multi-select-mode");
				}
				break;			
			case "content":
				var obj = $('#field-' + domId);
				if (value.length > 0){
					obj.html(value.replace(/\r?\n/g, '<br/>'));
				}else{
					obj.html('[empty paragraph]');
				}
				break;
			case "dictionary":
				 var selectList = targetContainer.find('select');
				 if (value.toLowerCase() == "null"){
					 selectList.find('option').remove();
					 $.each(["option 1","option 2", "option 3"], function (index, item) {							
							selectList.append('<option value="'+ item +'">' + item + '</option');
					 });
					 
					 // reset textbox
					 $('prop-options').val("option 1,option 2,option 3")
					 updateJSONObject(domId, 'dictionary', "");       
					 break;
				 }				 
				 
				 selectList.find('option')
						   .remove();
				 selectList.append('<option value="">loading dictionary...</option');
			     $.get('actions.php?a=get-content&d=' + value, null, function (obj) {
					 if (obj){
						// bind options to select list   						
						selectList.find('option').remove();
						$.each(obj, function (index, item) {							
							selectList.append('<option value="'+ item.key +'">' + item.value + '</option');
						});
					 }
				 });
				break;
        }
    }
	
	function initializeTimePickers(controlId, fmt){
		// set minute and am/pm fields
		var targetContainer = $('#drop-item-' + controlId);		
		var timeValues = getFormattedTimeValues(fmt);
		
		var hourddl = targetContainer.find('.hour');
		var minuteddl = targetContainer.find('.minute');
		var amPmDdl = targetContainer.find('.am-pm-field');
		
		hourddl.val(timeValues['hh']);
		minuteddl.val(timeValues['mm']);
		amPmDdl.val(timeValues['dd']);		
	}
	
	function getFormattedTimeValues(fmt){
		var d = new Date();
		var values = [];
		var hh = d.getHours();
		var m = d.getMinutes();
		var s = d.getSeconds();
		var dd = "AM";
		
		if (fmt !==undefined && fmt == '24'){
			values['hh']=hh;
			values['mm']=m;
		}else{
			var h = hh;
			if (h >= 12) {
				h = hh-12;
				dd = "PM";
			}
			if (h == 0) {
				h = 12;
			}
			values['hh'] = h;
			values['mm'] = m;
			values['dd'] = dd;
		}
		
		return values;
	}
	
	function initializeDatePickers(activeid){
		var jsonObject = getFieldJSONObject(activeid);		
		var language = getFieldJSONObjectValue(jsonObject, 'language');
		$U.bindFormDatePickers(activeid, language);
	}	

    function activateField(parentItem) {
        $('li.drop-item').removeClass('active');
        parentItem.addClass('active');
        activeControl = parentItem.attr('data-control-type');
        activeItemId = parentItem.attr('data-dom-id');
        loadProperties();
    }

    // binds all settings fields with a function
    // that triggers a broadcast of changes to subscribers
    function bindPublishers() {
        $('.is-publisher').live('change', function () {
            var propType = $(this).attr('data-field-property')
            if (propType) {
                doFieldSettingUpdates(activeItemId, propType, $(this).val());
            }

            $('#isAltered').val(1);
        });
    }


    function handleSaveCallback(content) {
        $('#IsAutoSave').val('false');
        var response = $.parseJSON(content.responseText);
        if (response && response.success) {
            if (!response.isautosave) {
                $U.writeSuccessToContainer($('#message'), response.message);
            }
            bindFieldIds(response.fieldids);
            $('#isAltered').val(0);
            $('#autosave-container').hide();
        } else {
            if (!response.isautosave) {
                $U.writeErrorToContainer($('#message'), response.error)
            }else{
				alert(response.error)
			}
        }

        enableSubmitButtons();
    }

    function bindFieldIds(idsObj) {
        
        if (idsObj && idsObj.length > 0) {
            for (var i = 1; i <= idsObj.length; i++) {
                var obj = idsObj[i - 1];				
                $('#field-prop-' + obj.domid).attr('data-field-id', obj.id);								
				updateJSONObject(obj.domid, 'id', obj.id);                				                				
            }
        }
    }

    function refreshForm() {
        if ($('ul#drop-form').find('li.drop-item').length > 0) {
            $('.publish-item').show();
            $('#isAltered').val(1);
            if ($('li.prompt-item').length > 0) {
                $('li.prompt-item').remove();
            }
        } else {
            $('.publish-item').hide();
            if ($('li.prompt-item').length == 0) {
                var promptTemplate = $('#form-field-prompt-template').tmpl();
                $('ul#drop-form').append(promptTemplate)
            }
        }
		
    }

    function bindAutoSave() {
        setInterval(function () {
            if ($('#isAltered').val() == "1") {
                $('#autosave-container').show();
                disableSubmitButtons();
                $('#IsAutoSave').val('true');
                $('#main-form').submit();
            }

        }, 15000);
    }

    function disableSubmitButtons() {
        $('.save-button').attr("disabled", "disabled");
        $('.save-button').addClass("disabled");
    }

    function enableSubmitButtons() {
        $('.save-button').removeAttr("disabled", "disabled");
        $('.save-button').removeClass("disabled");
    }

    function handleBeginSave() {
        // $U.log('beginning save');
        disableSubmitButtons();
        $('#isAltered').val(0); // prevent autosave while save in progress
    }

    function bindNavigateAway() {
        window.onbeforeunload = function () {
            if ($('#isAltered').val() == "1") {
                return "Are you sure you want to leave this page? Your changes have not been saved.";
            }

        };
    }
	
	function doEditorPinToggle() {
		$('.the-pin-icon').on('click', function(){
			if($(this).hasClass('pinned-icon-link'))
			{
				toggleEditorPin('.the-pin-icon', false);
			}else{
				toggleEditorPin('.the-pin-icon', true);
			}
			
		});			
	}
	
	function toggleEditorPin(pinButtons, doPin)
	{
		if(doPin){
			$(pinButtons).removeClass('unpinned-icon-link')
						 .addClass('pinned-icon-link')
			             .attr("title", "unpin property editor");
		}else{
			$(pinButtons).removeClass('pinned-icon-link')
						 .addClass('unpinned-icon-link')
						 .attr("title", "pin property editor");
		}
	}
	
	function scrollSideItemsIntoView(){
		toolboxId = "#property-editor-container";
		toolbox = $(toolboxId);
		originalElementTop = toolbox.offset().top;
		scroll_to = 0;
		
		$(window).on('scroll', function() {
			isEditorPinned = $('.the-pin-icon').first().hasClass('pinned-icon-link');
			windowScrollTop = $(window).scrollTop();
						
			if(!isEditorPinned){
				if(!isScrolledIntoView(toolboxId)){
					scroll_to = windowScrollTop <= originalElementTop ? 0 : (windowScrollTop-originalElementTop) + 10;				
					toolbox.stop().animate({"marginTop": scroll_to + "px"}, "slow" );
				}		
				
				if(windowScrollTop <= originalElementTop){
					toolbox.stop().animate({"marginTop": 0 + "px"}, "slow" );
				}		
			}
			
		});
	}
	
	function isScrolledIntoView(elem)
	{
			var win = $(window);
			var viewport = {
				top : win.scrollTop(),
				left : win.scrollLeft()
			};
			viewport.right = viewport.left + win.width();
			viewport.bottom = viewport.top + win.height();
			var bounds = $(elem).offset();
		    bounds.right = bounds.left + $(elem).outerWidth();
			bounds.bottom = bounds.top + $(elem).outerHeight();
			return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
	}
	
	function appendDebug(message){
		if($('#debug-pane').length == 0){
			$('body').append($('<div id="debug-pane" style="width:400px;height:90px;padding:10px;border:1px solid black;position:fixed;background-color:white;top:0;left:0;"></div>'))
		}
		
		$('#debug-pane').html(message);
	}
	
	function bindDependentFields(){
		
		// visibility dependence
		$.each($('[data-show-if]'), function(index, item){
				var elem = $(this);
				var dependencyValue = $(item).attr('data-show-if').split(':');
				processDependency("visibility", elem, dependencyValue);
		});
		
	}
	
	function processDependency(dependencyType, elem, dependencyValue)
	{
		switch(dependencyType.toUpperCase()){
			case "VISIBILITY":
			    var dependentElementId = dependencyValue[0];
				var dependentElement = $('#' + dependentElementId);
				var dependentValue = dependencyValue[1];
				
				if(dependentElement.length > 0 && dependentElement.is(':visible')){
					// attach handler to dependent element
					var dependentElementTag = dependentElement.prop('tagName');
					switch(dependentElementTag.toUpperCase()){
						case "SELECT":
							 triggerVisibilityDependence(elem, dependentElement, dependentValue);
							 dependentElement.unbind('change');
						     dependentElement.live('change',function(){
								triggerVisibilityDependence(elem, $(this), dependentValue);
							 });
						break;	 
					}
					
				}	
			break;
		}
	}
	
	function triggerVisibilityDependence(affectedField, dependentField, dependentValue){
		var actualValue = $(dependentField).val();
		if(actualValue == dependentValue){
			affectedField.show();
		}else{
			affectedField.hide();
		}
	}
	
	function bindToolHover(){
		$('li.form-tool').hover(function(){
			$(this).addClass('hover');
		}, function(){
			$(this).removeClass('hover');
		});
	}
	
	function bindTextEncrypt(){
		inputField = $('input[data-textmode=password]');
		inputField.live('keyup', function(){																
			var currValue = $(this).val();
			inputField.val(currValue.replace(/[\S]/g, "*"));									
		});
	}
	
	function selectEditorField(){
		$("#field-property-table input[type='text'], #form-property-table input[type='text']").click(function () {
			$(this).select();
		});
	}
	
	function bindUIFunctions(){
		scrollSideItemsIntoView();
		doEditorPinToggle();
		bindClickToAdd();
		bindDependentFields();	
		updateWizardStepsForAllControls();	
		bindToolHover();
		bindTextEncrypt();
		selectEditorField();
	}

    function init() {
        bindBasicActions();
        bindDragAndDrop();
		bindDroppableItems();
        bindSortable();
        bindEditables();
        bindPublishers();
        bindAutoSave();
        toggleSaveButton();
        bindNavigateAway();
		bindUIFunctions();				
    }

    return {
        init: init,
        handleSaveCallback: handleSaveCallback,
        handleBeginSave: handleBeginSave
    }
} ();