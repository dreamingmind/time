/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
})
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

function timeChange(e, action) {
    var id = $(e.currentTarget).attr('index');
    $.ajax({
        type: "GET",
        url: webroot + controller + action + "/" + id,
        dataType: "HTML",
        success: function (data) {
            if (data.match(/<tr/) != null) {
                replaceRow(data, id);
            } else {
                $('#row_' + id).before('<tr><td colspan="5" class="flashmessage"' + data + '</td></tr>');
            }
        },
        error: function () {
            alert('Error adding the time row.')
        }
    });
}

function timeStop(e) {
    e.preventDefault();
    timeChange(e, 'timeStop');
}

function timePause(e) {
    e.preventDefault();
    timeChange(e, 'timePause');
}

function timeRestart(e) {
    e.preventDefault();
    timeChange(e, 'timeRestart');
}

function timeReopen(e) {
    e.preventDefault();
    timeChange(e, 'timeRestart');
}

function timeDelete(e) {
    e.preventDefault();
    var c = confirm('Are you sure you want to delete this time record?');
    if (!c) {
        return;
    }
    var id = $('#' + $(this).attr('index') + 'TimeId').val();
    $.ajax({
        type: "POST",
        url: webroot + controller + "deleteRow/" + id,
        dataType: "JSON",
        success: function (data) {
            if (data.result) {
                $('#' + id + 'TimeId').parents('tr').remove();
            } else {
                alert('The deletion failed, please try again.');
            }
        },
        error: function () {
            alert('Error deleting the time row.')
        }
    });
}

function newTime(e) {
    e.preventDefault();

}

function timeInfo(e) {
    e.preventDefault();
    var target = e.currentTarget;
    var id = $(target).attr('index');
    $.ajax({
        type: "GET",
        dataType: "HTML",
        url: webroot + controller + 'edit/' + id + '/true',
        success: function (data) {
            $('div.times.form').remove();
            $(target).parents('td').prepend(data);
            bindHandlers('div.times.form');
            $('div.times.form').draggable();
        },
        error: function (data) {
            alert('There was an error on the server. Please try again');
        }
    })
}

function cancelTimeEdit(e) {
    e.stopPropagation();
    $('div.times.form').remove();
}

function saveTimeEdit(e) {
    e.preventDefault();
    e.stopPropagation();
    var id = $(e.currentTarget).attr('index');
//	var formData = $('form#TimeEditForm').serialize();
    $.ajax({
        type: "PUT",
        dataType: "HTML",
        data: $('form#TimeEditForm').serialize(),
        url: $('form#TimeEditForm').attr('action'),
        success: function (data) {
            if (data.match(/<tr/) != null) {
                replaceRow(data, id);
            } else {
                $('div.times form').prepend(data);
            }
        },
        error: function (data) {
            alert('failure');
        }
    })
}

/**
 * Replace the row contents with returned row
 */
function replaceRow(data, id) {
    $('#row_'+id).replaceWith(data);
    bindHandlers('#row_' + id);
    initToggles('#row_' + id);
    updateTableClassing();
    updateTableSortability();
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
            initToggles();
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
    var rows = $('table.sortable').find('tbody tr');
    rows.removeClass('alt first last');
    var table = $('table.sortable');
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

/**
 * Save a single field change on the timekeeping form
 */
function saveField(e) {
    var id = $(e.currentTarget).attr('index');
    var fieldName = $(e.currentTarget).attr('fieldName');
    var value = $(e.currentTarget).val();
    var postData = {'id': id, 'fieldName': fieldName, 'value': value};
    $.ajax({
        type: "POST",
        url: webroot + controller + "saveField",
        data: postData,
        dataType: "JSON",
        success: function (data) {
            if (fieldName == 'duration') {
                $('#' + id + 'duration').html(data.duration).trigger('click');
            }
            updateTableClassing();
            updateTableSortability();
            bindHandlers('table.sortable tr.last');
        },
        error: function () {
            alert('Error adding the time row.')
        }
    });

}
