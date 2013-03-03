$(function() {
    $('#submit_btn').click(function() {
        var task = $('input#task').val();
        var start = new Date().getTime();
        var dataString = 'action=createNewTask&task='+ task +'&start='+ start;
        $.ajax({
            type: 'POST',
            url: 'includes/TaskController.php',
            data: dataString,
            success: function() {
                $('#table-entries tr:last').after('<tr><td>'+ task +'</td><td>'+ $.format.date(start, "yyyy-MM-dd HH:mm") +'</td></tr>');
                $('input#task').val('');
            }
        });
        return false;
    });
});