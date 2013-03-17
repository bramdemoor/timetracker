$(function() {

    $('#tscode-txt').typeahead( {
        minLength: 1,
        source: function(typeahead, query) {
            $.ajax({
                type: 'GET',
                url: 'Library/TaskController.php',
                data: 'action=getTsCodes',
                dataType: 'json',
                success: function(data) {
                    console.log("tscode called");
                    console.log(data);
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
                    url: 'Library/TaskController.php',
                    data: 'action=getEntryNames',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
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
        var dataString = 'action=removeEntry&pk=' + $id;
        var rowElement = $(this).closest('tr');
        $.ajax({
            type: 'POST',
            url: 'Library/TaskController.php',
            data: dataString,
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
        url: '/TaskController.php',
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
            url: 'Library/TaskController.php'
        }
    });

    $('#submit_btn').click(function() {
        var tscode = $('input#tscode-txt').val();
        var task = $('input#task-txt').val();
        var start = new Date().getTime();
        var dataString = 'action=createNewTask&tsCode=' + tscode + '&task='+ task +'&start='+ start;
        $.ajax({
            type: 'POST',
            url: 'Library/TaskController.php',
            data: dataString,
            success: function() {
                $('#table-entries tr:last').after('<tr><td class="tscode-field" >'+ tscode +'</td><td class="task-field" >'+ task +'</td><td class="datetime-field">'+ $.format.date(start, "yyyy-MM-dd HH:mm") +'</td><td class="button-group"><a href="#" class="edit-btn" style="display: none;"><i class="icon-edit"></i></a><a href="#" class="remove-btn" style="display: none;"><i class="icon-remove"></i></a></td></tr>');
                $('input#task-txt').val('');
                $('input#tscode-txt').val('');
            }
        });
        return false;
    });
});