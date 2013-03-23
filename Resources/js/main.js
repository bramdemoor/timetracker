$(function() {

    $('#tscode-txt').typeahead( {
        minLength: 1,
        source: function(typeahead, query) {
            $.ajax({
                type: 'GET',
                url: 'index.php?entries&getTsCodes',
                dataType: 'json',
                success: function(data) {
                    typeahead.process(data);
                }
            })
        },
        property: 'TSCode'
    });

    $('#task-txt').typeahead( {
        minLength: 1,
            source: function(typeahead, query) {
                $.ajax({
                    type: 'GET',
                    url: 'index.php?entries&getEntryNames',
                    dataType: 'json',
                    success: function(data) {
                        typeahead.process(data);
                    }
                })
        },
        property: 'Task'
    });

    $(".task-entry").hover(
        function() { $(this).children(".button-group").children(".remove-btn, .edit-btn").show(); },
        function() { $(this).children(".button-group").children(".remove-btn, .edit-btn").hide(); }
    );

    $('.edit-btn').click(function(e) {
        e.stopPropagation();
        var currentTablerow = $(this).closest('tr');
        currentTablerow.children(".task-field").editable('toggle');
    });

    $('.remove-btn').click(function() {
        var $id = $(this).closest('tr').children('.task-field').attr('data-pk');
        var rowElement = $(this).closest('tr');
        $.ajax({
            type: 'POST',
            url: 'index.php?entries&removeEntry&pk=' + $id,
            success: function() {
                rowElement.remove();
            }
        });
        return false;
    });

    $.fn.editable.defaults.mode = 'inline';

    $('.task-field').editable({
        type: 'text',
        id: 'Task',
        url: 'index.php',
        toggle: 'manual',
        inputclass:'input-inline-text',
        showbuttons: false,
        title: 'Enter new value...',
        params: function(params) {
            params.action = 'updateTaskDescription';
            return params;
        },
        ajaxOptions: {
            type: 'POST',
            url: 'index.php?entries&updateTaskDescription'
            }
    });

    function idCurrentRow(element) {
        return 'index.php?entries&updateTaskDescription&pk=50';
    }

    $('#submit_btn').click(function() {
        var tscode = $('input#tscode-txt').val();
        var descr = $('input#task-txt').val();
        var start = new Date().getTime();
        $.ajax({
            type: 'POST',
            url: 'index.php?entries&createNewEntry&tsCode=' + tscode + '&description='+ descr +'&start='+ start,
            success: function() {
                var idDate = $.format.date(start, 'dd-MM-yyyy');
                //check if current day is already present
                if($('#' + idDate).length == 0) {
                    $('#table-entries h5:first').before(
                        '<h5>'+ $.format.date(start, 'ddd dd MMMM yyyy') +'</h5>' +
                        '<table id="'+ idDate +'" class="table table-hover table-condensed"><tr></tr></table>');
                }
                $('#table-entries table:first tr:first').before(
                    '<tr class="task-entry"><td class="tscode-field" >'+ tscode +
                        '</td><td class="task-field" >'+ descr +
                        '</td><td class="datetime-field"><small>Start:</small> '+ $.format.date(start, "HH:mm") +
                        '</td><td class="button-group"><a href="#" class="edit-btn" style="display: none;"><i class="icon-edit">' +
                        '</i></a><a href="#" class="remove-btn" style="display: none;"><i class="icon-remove"></i></a></td></tr>');
                $('input#task-txt').val('');
                $('input#tscode-txt').val('');
            }
        });
        return false;
    });

    $('#submit-export').click(function() {
        $.ajax({
            type: 'GET',
            url: 'index.php?export&all',
            datetype: 'json',
            success: function(data) {
                //TODO: put basepath in setting
                var fname = '/timetracker/Exports/' + data[0].filename;
                $.fileDownload(fname);
            }
        });
    });
});