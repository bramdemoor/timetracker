$(function() {

	var viewModel = function() {
		var self = this;
		self.entries = ko.observableArray(['test','test2']);
	}

    $('#tscode-txt').typeahead( {
        minLength: 1,
        source: function(typeahead, query) {
            $.ajax({
                type: 'GET',
                url: '/tsccodes',
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
                    url: '/entrynames',
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
        $.ajax({
            type: 'POST',
            url: '#',
            success: function() {                
            }
        });
        return false;
    });

    $.fn.editable.defaults.mode = 'inline';

    $('.task-field').editable({
        type: 'text',
        id: 'Task',
        url: '#',
        toggle: 'manual',
        inputclass:'input-inline-text',
        showbuttons: false,
        title: 'Enter new value...',
        params: function(params) { return params; },
        ajaxOptions: {
            type: 'POST',
            url: '#'
            }
    });

    function idCurrentRow(element) {
        return '#';
    }

    $('#submit_btn').click(function() {
        var tscode = $('input#tscode-txt').val();
        var descr = $('input#task-txt').val();
        var start = new Date().getTime();
        $.ajax({
            type: 'POST',
            url: '#',
            success: function() { }
        });
        return false;
    });  
	
	ko.applyBindings(new viewModel());
});