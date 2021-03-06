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
		self.inEditMode = ko.observable(false);
		self.edit = function() {
			self.inEditMode(true);
		}
		self.remove = function() {
			console.log('remove row');
			// post delete
		}
	}

	var viewModel = function() {
		var self = this;
		self.tsCode = ko.observable('');
		self.task = ko.observable('');
		self.entries = ko.observableArray([]);
		self.today = ko.computed(function() {
			return moment().format('dddd DD/MM/YYYY');
		});
		
		$.getJSON('/entries', function(data) {
			self.entries(ko.utils.arrayMap(data, function(item) {
				return new entryModel(item.Id, item.TSCode, item.Task, item.Start);
			}));
		});
		
		self.addEntry = function() {
			console.log('add entry!');
			// new Date();
			// DO POST
		}
	}

    $('#tscode-txt').typeahead( {
        source: function(query, process) { $.getJSON('/tsccodes', function(data) { process(data) }) }
    });
	
    $('#task-txt').typeahead( {
        source: function(query, process) { $.getJSON('/entrynames', function(data) { process(data) }) }
    });	

	ko.applyBindings(new viewModel());
});