$(function() {

	var entryModel = function(id, tsCode, task, start) {
		var self = this;
		self.id = ko.observable(id);
		self.tsCode = ko.observable(tsCode);
		self.task = ko.observable(task);
		self.start = ko.observable(start);
		self.startFormatted = ko.computed(function() {
			return moment(self.start()).format('h:mm');
		});
		self.rowClass = ko.computed(function() {
			if(self.tsCode() == 'Break') return 'warning';
			if(self.tsCode() == 'Stop') return 'error';
			return '';
		});
		self.isHovered = ko.computed(function() {
			return true;
		});
	}

	var viewModel = function() {
		var self = this;
		self.entries = ko.observableArray([]);
		self.today = ko.computed(function() {
			return moment().format('dddd DD/MM/YYYY');
		});
		
		$.getJSON('/entries', function(data) {
			self.entries(ko.utils.arrayMap(data, function(item) {
				return new entryModel(item.Id, item.TSCode, item.Task, item.Start);
			}));
		});
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
        /*currentTablerow.children(".task-field").editable('toggle');*/
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

   /* $('.task-field').editable({
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
    });*/

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