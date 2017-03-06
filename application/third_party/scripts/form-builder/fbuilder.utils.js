var $U =
{

    bindLightboxes: function () {
        $('.close-modal').live('click', function (event) {
            event.preventDefault();
            $.modal.close();
        })

        $('.lightbox').live('click', function (event) {
            event.preventDefault();

            var ajax_url = $(this).attr('href');
            $.modal($U.getPreloader(), {
                minWidth: 600,
                position: ["25%", "25%"],
                onShow: function (dialog) { $U.doModalAjax(ajax_url, dialog); }

            });
            return false;
        });

    },

    replaceQueryString: function (url, param, value) {
        var re = new RegExp("([?|&])" + param + "=.*?(&|$)", "i");
        if (url.match(re))
            return url.replace(re, '$1' + param + "=" + value + '$2');
        else {

            if (url.indexOf('?') > -1) {
                return url + '&' + param + "=" + value;
            } else {
                return url + '?' + param + "=" + value;
            }

        }
    },

    bindNumerics: function () {
        $('.numeric-entry').numeric();
    },
	
	bindInputMasks: function(){
		try{
			$('input.masked-field').inputmask();
		}catch(e){
			$U.log('unbale to bind input masks. scripts might not be loaded');
		}
	},
	
	bindStepper: function(){
		try{
			$('input.stepper-field').stepper();
		}catch(e){
			$U.log('unbale to bind input masks. scripts might not be loaded');
		}
	},

    bindAjaxActionLinks: function () {
        $('.ajax-action-link').live('click', function (e) {
            var method = $(this).attr('data-method');
            var callback = $(this).attr('data-callback');
            var spinnerId = $(this).attr('data-spinner');
            var spinner = {};
            if (spinnerId) { spinner = $('#' + spinnerId); }

            if (method && callback) {
                e.preventDefault();
                var url = $(this).attr('href');
                var data = $(this).attr('data-params');
                var dataObj = data ? $.parseJSON(data) : {};

                if (spinner.length > 0) { spinner.show(); }

                $.ajax({
                    type: method.toUpperCase(),
                    url: url,
                    data: dataObj,
                    success: function (response) {
                        $U.executeFunctionByName(callback, window, response);

                        if (spinner.length > 0) {
                            spinner.hide();
                        }
                    }

                });
            }
        })

    },


    executeFunctionByName: function (functionName, context, arguments) {
        var args = Array.prototype.slice.call(arguments).splice(2);
        var namespaces = functionName.split(".");
        var func = namespaces.pop();
        for (var i = 0; i < namespaces.length; i++) {
            context = context[namespaces[i]];
        }
        return context[func].apply(this, args);
    },

    trim: function (s) {
        s = s.replace(/(^\s*)|(\s*$)/gi, "");
        s = s.replace(/[ ]{2,}/gi, " ");
        s = s.replace(/\n /, "\n");
        return s;
    },

    preventDoubleFormSubmit: function () {

        try {
            $('.prevent-double-submit,.block-ui').submit(function () {

                if ($(this).valid()) {
                    $.blockUI({
                        message: 'Processing your order...',
                        css: {
                            border: 'none',
                            padding: '15px',
                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .8,
                            color: '#fff'
                        }
                    });
                }

            });
        }
        catch (ex) {
            $U.log(ex)
            $U.log('Unable to double-submit-proof');

        }


    },

    doModalAjax: function (url, dialog) {
        $.ajax(
                {
                    url: url,
                    type: 'GET',
                    success: function (result) {
                        dialog.data.html(result);
                    }
                }
        );
    },

    bindConfirmButtons: function () {
        $('.confirm-submit-link').live('click', function () {
            var title = $(this).attr('title')
            var msg = "Are you sure you wish to proceed?"

            if (title) {
                msg = title;
            }
            if (confirm(msg)) {
                $(this).parents('form:first').submit();
            }
        })
    },

    bindMoreLess: function () {
        $('.more-less').each(function (index, item) {
            try {
                var minimum = $(item).attr('data-minimum');
                var collapsedText = $(item).attr('data-collapsed-text');
                var expandedText = $(item).attr('data-expanded-text');

                if (!minimum) { minimum = 300; }
                if (!collapsedText) { collapsedText = "...More"; }
                if (!expandedText) { expandedText = "Less..."; }


                $(item).moreLess({
                    minimumTextLength: minimum,
                    collapsedText: collapsedText,
                    expandedText: expandedText
                });
            } catch (ex) {
                $U.log('more less not loaded');
            }
        });
    },

    getPreloader: function () {
        return "<div class=\"preloader\"><img style=\"margin-left:auto;display:block;margin-right:auto;\" src=\"/content/images/preloader.gif\" /></div>";
    },


    writeMessageAndRefreshPage: function (message) {
        $('#simplemodal-data').find('#content').hide();
        $('#simplemodal-data').find('input[type=submit]').attr('disabled', 'disabled');
        $('#simplemodal-data').find('input[type=submit]').css('visibility', 'hidden');
        var instructions = $('#simplemodal-data').find('#instructions');
        instructions.find('div:first').fadeOut('fast', function () {
            var noticeEl = $("<div class='success'>" + message + "</div>");
            noticeEl.appendTo(instructions);
        }).delay(950).queue(function () {
            window.location = window.location
        });
    },

    writeMessageAndCloseLightbox: function (message) {
        $('#simplemodal-data').find('#content').hide();
        $('#simplemodal-data').find('input[type=submit]').attr('disabled', 'disabled');
        $('#simplemodal-data').find('input[type=submit]').css('visibility', 'hidden');
        var instructions = $('#simplemodal-data').find('#instructions');
        instructions.find('div:first').fadeOut('fast', function () {
            var noticeEl = $("<div class='success'>" + message + "</div>");
            noticeEl.appendTo(instructions);
        }).delay(950).queue(function () {
            $.modal.close();
        });
    },

    writeErrorInLightbox: function (message) {
        var instructions = $('#simplemodal-data').find('#instructions');
        instructions.find('div:first').fadeOut('fast', function () {
            if (instructions.find('div.error').length == 0) {
                var noticeEl = $("<div class='error'>" + message + "</div>");
                noticeEl.appendTo(instructions);
            } else {
                instructions.find('div.error').html(message);
            }
        });
    },

    clearErrorFromLightbox: function () {
        var instructions = $('#simplemodal-data').find('#instructions');
        instructions.find('div:first').fadeOut('fast', function () {
            if (instructions.find('div.error').length > 0) {
                instructions.find('div.error').remove();
            }
        });
    },

    writeErrorAndCloseLightbox: function (message) {
        $('#simplemodal-data').find('#content').hide();
        $('#simplemodal-data').find('input[type=submit]').attr('disabled', 'disabled');
        $('#simplemodal-data').find('input[type=submit]').attr('visibility', 'hidden');
        var instructions = $('#simplemodal-data').find('#instructions');
        instruction.remove('.error');
        instructions.find('div:first').fadeOut('fast', function () {
            var noticeEl = $("<div class='error'>" + message + "</div>");
            noticeEl.appendTo(instructions);
        }).delay(950).queue(function () { $.modal.close(); });
    },

    highlight: function (item) {
        $(item).animate({ backgroundColor: '#FFFFAA' }, 'fast', function () {
            $(item).animate({ backgroundColor: '#FFFFFF' }, 'fast', function () {
                $(item).removeAttr('style')
            });
        })
    },

    bindPopups: function () {
        $('.popup-window, .popup').live('click', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            var scrollbars = $(this).attr('data-scrollbars');
            var resizable = $(this).attr('data-resizable');
            var width = $(this).attr('data-width');
            var height = $(this).attr('data-height');
            var windowName = $(this).attr('data-name');
            var location = $(this).attr('data-location');
            var status = $(this).attr('data-status');
            var moveX = $(this).attr('data-move-x');
            var moveY = $(this).attr('data-move-y');
            var debug = $(this).attr('data-debug');


            if (scrollbars == undefined) { scrollbars = 1; }
            if (resizable == undefined) { resizable = 0; }
            if (width == undefined) { width = "50"; }
            if (height == undefined) { height = "50"; }
            if (windowName == undefined) { windowName = "Formbuilder"; }
            if (height == undefined) { location = "0"; }
            if (status == undefined) { status = "1"; }
            if (moveX == undefined) { moveX = 0; }
            if (moveY == undefined) { moveY = 0; }
            if (debug != undefined) { console.log('width:' + width + '\nheight:' + height + '\nname:' + windowName); }

            var myWindow = window.open(url, windowName, 'location=' + location + ',status=' + status + ',scrollbars=' + scrollbars + ',resizable=' + resizable + ',width=' + width + ',height=' + height + '')
            myWindow.moveTo(parseInt(moveX), parseInt(moveY));

        });
    },

    bindCheckboxSubmit: function () {
        $('.checkbox-submit').live('click', function () {
            $(this).closest('form').submit();
        })
    },

    preventEnterSubmit: function () {

        var keyStop = {
            8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
            13: "input:text, input:password", // stop enter = submit 
            end: null
        };

        $('.prevent-enter-submit').bind("keydown", function (event) {
            var selector = keyStop[event.which];

            if (selector !== undefined && $(event.target).is(selector)) {
                event.preventDefault(); //stop event
            }
            return true;
        });

    },

    showHiddenFieldValues: function (log) {
        var values = '';
        $('input[type=hidden]').each(function () {
            values = values + $(this).attr("id") + ":" + $(this).val() + "\n";
        });

        if (log) {
            $U.log(values)
        } else {
            alert(values);
        }
    },

    bindTipsies: function () {
        try {
            $('.n-tip').tipsy({ gravity: 'n', title: 'title', live: true });
            $('.s-tip').tipsy({ gravity: 's', title: 'title', live: true });
            $('.e-tip').tipsy({ gravity: 'e', title: 'title', live: true });
            $('.w-tip').tipsy({ gravity: 'w', title: 'title', live: true });
            $('.img-tip').tipsy({ gravity: 'w',html: true, title: function () { return "<img class='img-hover-preview' src='" + this.getAttribute('data-image-path') + "' alt='image preview' />" }, live: true, });
        } catch (e) {
            $U.log('unable to bind tooltips. Scripts might not be loaded')
        }
    },

    bindWatermarks: function () {
		//deprecated
        // bind watermarked items
        // try {
            // $('.watermarked').each(function () {
                // if ($(this).attr('title')) {
                    // $(this).watermark($(this).attr('title'), { className: 'watermark' });
                // }
            // });
        // } catch (e) {
            // $U.log('unable to bind watermarks. Scripts might not be loaded')
        // }
    },

    removeWatermarks: function () {

        // bind watermarked items
        try {
            $.watermark.hideAll();
        } catch (e) {
            $U.log('unable to clear watermarks. Scripts might not be loaded')
        }
    },

    bindElastics: function () {
        try {
            $('.elastic').elastic();
        } catch (e) {
			//$U.log('unable to bind elastic. Scripts might not be loaded')
        }
    },

    writeErrorToContainer: function (target, error) {
        $(target).removeClass('success').removeClass('notice').addClass("error");
        $(target).html(error);
    },

    writeSuccessToContainer: function (target, msg) {
        $(target).removeClass('error').removeClass('notice').addClass("success");
        $(target).html(msg);
    },

    bindTextAreaMax: function () {
        $('textarea').each(function (index, item) {
            if ($(item).attr('maxlength')) {
                var maxLength = $(item).attr('maxlength');
                if (maxLength > 0) {
                    $(item).maxlength({ maxCharacters: maxLength, statusClass: 'chars-left' });
                }
            }

        });
    },

    messageSendComplete: function () {
        $U.writeMessageAndCloseLightbox("Your message was sent");
    },

    bindLinkButtonSubmit: function () {
        $('.submit-link').live('click', function () {
            if (!$(this).hasClass('disabled')) {
                $(this).closest('form').submit();
            }
        })

    },

    log: function (logvar) {
        if ((window['console'] !== undefined)) {
            console.log(logvar);
        };
    },

    bindRedirectButton: function () {
        $('.redirect-button').live('click', function (event) {
            event.preventDefault();
            var link = $(this).attr('data-href');
            if (link) {
                window.location = link;
            }

        });

    },
	
	bindFormDatePickers: function(activeid, language) {
		var dataObj = $('#date-item-list-container-' + activeid);
		var showtime = dataObj.hasClass('show-time-mode');
		var isTwentyFourHourMode = dataObj.hasClass('twenty-four-hour-mode'); 
		var isTwoDateMode = dataObj.hasClass('two-date-mode'); 
		var language = (typeof language != "undefined") ? language : dataObj.attr('data-language');
		var regionPrefix = language.indexOf("-") > -1 ? language.split('-')[0] : language;
		
		if(regionPrefix	== "en"){ regionPrefix = ""; }
				
		// destroy existing datepicker handlers
		var fromSelector = '#SubmitFields-'+ activeid + '-Date1';
		var toSelector = '#SubmitFields-'+ activeid + '-Date2';				
					
		if($(fromSelector).hasClass('hasDatepicker')){			
			$( fromSelector ).datepicker('destroy');
		}
		
		if($(toSelector).hasClass('hasDatepicker')){			
			$( toSelector ).datepicker('destroy');
		}
		
				
		if (isTwoDateMode == "true" || isTwoDateMode == "True" || isTwoDateMode == true)
		{		
			$( fromSelector ).datepicker($.extend({}, $.datepicker.regional[regionPrefix],{
			  defaultDate: "+1w",
			  changeMonth: true,
			  numberOfMonths: 2,			  
			  onClose: function( selectedDate ) {
				$( toSelector).datepicker( "option", "minDate", selectedDate );
			  }
			}));
			
			$( toSelector ).datepicker($.extend({}, $.datepicker.regional[regionPrefix],{
			  defaultDate: "+1w",
			  changeMonth: true,
			  numberOfMonths: 2,			  
			  onClose: function( selectedDate ) {
				$( fromSelector ).datepicker( "option", "maxDate", selectedDate );
			  }
			}));
			
		}else{
			$(fromSelector).datepicker($.datepicker.regional[regionPrefix]);
			$(toSelector).datepicker($.datepicker.regional[regionPrefix]);
		}		
		
		// bind calendar icon click handlers
		$('.datepicker-from-select-icon-link-' + activeid).live('click', function(e){			
			$(fromSelector).datepicker('show');
		});
		
		$('.datepicker-to-select-icon-link-' + activeid).live('click', function(e){			
			$(toSelector).datepicker('show');
		});
			
	}
};