/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    bindHandlers();
})
/**
 * Sweep the page for bindings indicated by HTML attribute hooks
 * 
 * Class any DOM element with event handlers.
 * Place a 'bind' attribute in the element in need of binding.
 * bind="focus.revealPic blur.hidePic" would bind two methods
 * to the object; the method named revealPic would be the focus handler
 * and hidePic would be the blur handler. All bound handlers
 * receive the event object as an argument
 * 
 * Version 2
 * 
 * @param {string} target a selector to limit the scope of action
 * @returns The specified elements will be bound to handlers
 */
function bindHandlers(target) {
    if (typeof (target) == 'undefined') {
        var targets = $('*[bind*="."]');
    } else {
        var targets = $(target).find('*[bind*="."]')
    }
    targets.each(function () {
        var bindings = $(this).attr('bind').split(' ');
        for (i = 0; i < bindings.length; i++) {
            var handler = bindings[i].split('.');
            if (typeof (window[handler[1]]) === 'function') {
                // handler[0] is the event type
                // handler[1] is the handler name
                $(this).off(handler[0]).on(handler[0], window[handler[1]]);
            }
        }
    });
}

function OutNow(e) {
    e.preventDefault();
    var d = new Date();
    var monthstring = (parseInt(d.getMonth()) + 1).valueOf();
    var month = ('0' + monthstring).substr(-2);
    var day = ('0' + d.getDate()).substr(-2);
    var dstring = d.getFullYear() + '-' + month + '-' + day + ' ' + d.toLocaleTimeString();
    alert(d);
    $(this).parents('form').find('#TimeTimeOut').attr('value', dstring);
}

function AdjustSelect(e) {
    //Get curr datetime
    var d = new Date();
    //set variable for users adjustment selection
    var adj = parseInt($(this).val());
    //Adjust per parameters
    var dadj = d.setMinutes(d.getMinutes() + adj);
    //Set new value to d

    //Reformat for output
    var monthstring = (parseInt(d.getMonth()) + 1).valueOf();
    var month = ('0' + monthstring).substr(-2);
    var day = ('0' + d.getDate()).substr(-2);
    var dstring = d.getFullYear() + '-' + month + '-' + day + ' ' + d.toLocaleTimeString();
//            alert(dadj);
    $(this).parents('form').find('#TimeTimeOut').attr('value', dstring);
}

function timeStop(e) {
    e.preventDefault();
}

function timePause(e) {
    e.preventDefault();
}

function timeBack(e) {
    e.preventDefault();
}

function newTime(e) {
    e.preventDefault();

}

/**
 * Set the default project for new time entries
 */
function setDefaultProject() {
    e.preventDefault();
    alert('Set default project');
}

/**
 * Create a new row for time keeping
 */
function newTimeRow(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: webroot + controller + "newTimeRow",
        dataType: "html",
        success: function (data) {
            $('#TimeTrackForm tbody').append(data);
            updateTableClassing();
            updateTableSortability();
            bindHandlers('table.sortable tr.last');
        },
        error: function () {
            alert('Error adding the time row.')
        }
    });

}

/**
 * Update table classing for kickstart after AJAX insertion
 */
function updateTableClassing() {
    rows.removeClass('alt first last');
    var table = $(this).parents('table.sortable');
    table.find('tr:even').addClass('alt');
    table.find('tr:first').addClass('first');
    table.find('tr:last').addClass('last');

}

/**
 * Update sortability on AJAX inserted row
 */
function updateTableSortability() {
    $(this).find('table.sortable tr.last th,td').each(function () {
        $(this).attr('value', $(this).text());
    });
}
