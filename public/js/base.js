// JavaScript Document

$(document).ready(function() {
	
        /*
         * Replace all text area instances with CKeditor
         */
        CKEDITOR.replaceAll();
        
        /*
         * Confirms a form submission
         */
        $(document).on('click', '.confirm', function(e){
            e.preventDefault();

            //Get the closest form to submit
            var form = $(this).closest('form'); 
            //
            //Get the message to display for confirmation
            var message = $(this).data('confirm-message'); 
            
            //Check if the message is present or not
            if(typeof message === 'undefined'){
                //Set a default message if the message is not present
                message = "Are you sure?";
            }
            
            //Run confirm modal
            bootbox.confirm(message, function(result) {
                if(result){
                    //If user clicks ok, submit the form
                    form.submit();
                } else{
                    //Close modal and do nothing
                }
            }); 
        });
        
        /*
         * Submits post forms via ajax and returns the response
         */
        $(document).on('submit', '.ajax-form-post', function(e) {
            e.preventDefault();
            
            var refreshTarget = $(this).data('refresh-target');
            
            if(typeof refreshTarget !== 'undefined'){
                $(this).ajaxSubmit({
                    success: function(response, status, xhr, $form){
                        showFormResponse(response, status, xhr, $form);
                        refreshContent(refreshTarget);
                    }
                });
            } else {
                $(this).ajaxSubmit({
                    success: showFormResponse
                });
            }
        });
        
        /*
         * Submits get forms via ajax and returns the response
         */
        $(document).on('submit', '.ajax-form-get', function(e){
            e.preventDefault();
            
            var refreshTarget = $(this).data('refresh-target');
            
            $(this).ajaxSubmit({
                success: function(response, status, xhr, $form){
                    refreshContent(refreshTarget, response);
                    
                }
            });
        });
        
        /*
         * Paginates table information without refresh
         */
        $(document).on('click', '.pagination li a', function(e){
            e.preventDefault();
            paginate($(this).attr('href'), '#resource-paginate');
        });
        
        /*
         * Replace fields with class .pickatime with Pickatime
         */
	if($.isFunction($().pickatime)){
		$('.pickatime').pickatime();
	}
	
        /*
         * Replace fields with class .pickadate with Pickadate,
         * and set the default date format
         */
	if($.isFunction($().pickadate)){
		$('.pickadate').pickadate({
			formatSubmit: 'yyyy/mm/dd',
			hiddenName: true
		});
	}
	
	
	if($.isFunction($().typeahead)){
            // Workaround for bug in mouse item selection
            $.fn.typeahead.Constructor.prototype.blur = function() {
                var that = this;
                setTimeout(function () { that.hide() }, 250);
            };

            $('input[name="make"]').typeahead({
                source: function (query, process) {
                        return $.get('/api/assets/makes', { query: query }, function (data) {
                                return process(data);
                        });
                }
            });

            $('input[name="model"]').typeahead({
                source: function (query, process) {
                        return $.get('/api/assets/models', { query: query }, function (data) {
                                return process(data);
                        });
                }
            });

            $('input[name="serial"]').typeahead({
                source: function (query, process) {
                        return $.get('/api/assets/serials', { query: query }, function (data) {
                                return process(data);
                        });
                }
            });
	}

    $(document).on('click', 'a[data-method]', function(e){
            e.preventDefault();
            var link = $(this);

            var httpMethod = link.data('method').toUpperCase();
            var allowedMethods = ['POST', 'PUT', 'DELETE'];
            var msg = link.data('message');
            var title = link.data('title');

            // If the data-method attribute is not PUT or DELETE,
            // then we don't know what to do. Just ignore.
            if ( $.inArray(httpMethod, allowedMethods) === - 1 )
            {
                    return;
            }

            bootbox.dialog({
                    message: msg,
                    title: title,
                    buttons: {
                            main: {
                                    label: "Cancel",
                                    className: "btn-default"
                            },
                            success: {
                                    label: "Ok",
                                    className: "btn-primary",
                                    callback: function() {
                                        var form =
                                                $('<form>', {
                                                        'method': 'POST',
                                                        'action': link.attr('href')
                                                });

                                        var hiddenInput =
                                                $('<input>', {
                                                        'name': '_method',
                                                        'type': 'hidden',
                                                        'value': link.data('method')
                                                });

                                        if(link.data('method') === "POST"){
                                            form.appendTo('body').submit(); 
                                        } else{
                                            form.append(hiddenInput).appendTo('body').submit();  
                                        }

                                    }
                            }
                    }
            });

    });

    $(document).on('click', '.notification', function(){

        var url = $(this).data('read-url');

        $.post( url, { _method: "PATCH", read: "1"})
                .done(function(data){
                    return true;
                });
    });
    
    /*
     * Shows bootbox form from returned HTML to dynamically update stock locations
     */
    $(document).on('click', '.update-stock', function(e){
        
        e.preventDefault();
        
        var link = $(this);
        
        $.get(link.attr('href'), function(data){
            bootbox.dialog({
                message: data.html,
                buttons: {}
            });
        });
        
    });
    
});

/**
 * Accepts errors from a JSON response and displays them to the user on each
 * individual input
 * 
 * @param {type} errors
 * @returns {undefined}
 */
var showFormErrors = function(errors)
{
    $('.status-message').remove();
    $('.errors').remove();
    $('.form-group').removeClass('has-error');
    
    for(var errorType in errors)
    {
        var input = $('[name="'+errorType+'"]');
        
        for(var i in errors[errorType])
        {
            input.closest('.form-group').addClass('has-error');
            
            if(input.closest('.input-group').length > 0){
                var group = input.closest('.input-group');

                group.after('<span class="label label-danger errors error-'+errorType+'">'+errors[errorType][i]+'</span>');
            } else{
                input.after('<span class="label label-danger errors error-'+errorType+'">'+errors[errorType][i]+'</span>');
            }
        }
    }
};

/**
 * Displays the message returned from the server on an ajax request
 * 
 * @param {type} message
 * @param {type} type
 * @param {type} container
 * @returns {undefined}
 */
var showStatusMessage = function(message, type, container)
{
    $('.status-message').remove();
    $('.errors').remove();
    $('.form-group').removeClass('has-error');
    
    var html = '<div class="status-message">\n\
                    <div class="col-md-12">\n\
                        <div class="alert alert-'+type+' alert-dismissable">\n\
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n\
                            '+message+'\n\
                        </div>\n\
                    </div>\n\
            </div>';
    
    var fadeTime = 200;
    
    if(typeof container === "undefined") {
        $(html).prependTo('#alert-container').hide().fadeIn(fadeTime);
    } else{
        $(html).prependTo(container).hide().fadeIn(fadeTime);
    }
	
};

/**
 * Processes the response from the server upon ajax request
 * 
 * @param {type} response
 * @param {type} status
 * @param {type} xhr
 * @param {type} $form
 * @returns {undefined}
 */
var showFormResponse = function(response, status, xhr, $form){
    if(typeof response.messageType !== 'undefined'){ //Check if a message exists
        
        var statusContainer = $form.data('status-target');
        
        if(typeof statusContainer !== 'undefined'){
            showStatusMessage(response.message, response.messageType, statusContainer);
        } else{
            showStatusMessage(response.message, response.messageType);
        }
        
        if($form.hasClass('clear-form')){
            $form.clearForm();
        }
    } else if(typeof response.errors !== 'undefined') {
        showFormErrors(response.errors);
    } else{
        
    }
}

/**
 * Formats an icon into a select2 list
 * 
 * @param {type} icon
 * @returns {String}
 */
function formatIcon(icon) {
	return "<i class='" + icon.id.toString() + "'></i> " + icon.text;
}

/**
 * Formats a label into a select2 list
 * 
 * @param {type} color
 * @returns {String}
 */
function formatColor(color) {
	return "<span class='label label-" + color.id.toString() + "'>" + color.text + "</span> ";
}

/**
 * Updates a calendar event
 * 
 * @param {type} calendar
 * @param {type} event
 * @returns {Boolean}
 */
function updateEvent(calendar, event){
    var form =
        $('<form>', {
        'method': 'POST',
        'action': calendar.data('event-url')+"/"+event.id
    });

    form.appendTo('body');

    form.on('submit', function(){
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: {
                _method: 'PATCH',
                start: $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss"),
                end: $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss"),
                all_day: event.allDay
            },
            dataType: "json"
        }).done(function(result) {
            if(calendar.fullCalendar('refetchEvents')){
                calendar.fullCalendar('rerenderEvents');
            }
        });

        return false;
    });

    form.submit();

    return true;
}

/**
 * Refreshes the targeted area of a page
 * 
 * @param {type} target
 * @param {type} data
 * @returns {undefined}
 */
function refreshContent(target, data){
    
    if(typeof data !== 'undefined'){
        html = $(data).find(target);
        $(target).replaceWith(html);
    } else {
        var url = window.location;

        $.get(url, function(data){
            html = $(data).find(target);
            $(target).replaceWith(html);
        });
    }
}

/**
 * Paginates with ajax
 * 
 * @param {type} url
 * @param {type} target
 * @returns {undefined}
 */
function paginate(url, target){
    $.ajax(
    {
        url: url,
        type: "GET",
        datatype: "html"
    })
    .done(function(data)
    {
        html = $(data).find(target);
        $(target).replaceWith(html);
    });
}