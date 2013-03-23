var fs = require('fs');
var express = require('express');
var app = express();

app.use(express.logger('dev'));
app.use(express.static(__dirname + '/public'));

app.listen(8080);

/*
	getAllEntries: "SELECT * FROM entries" (getAllEntries order by Start asc)
		
	createNewEntry => insertTask($tsCode, $description, $start)
	createNewEntry => createNewEntry($vars['tsCode'], $vars['description'], time());
	// TODO: Do insert using these values
	
	updateTaskDescription => updateTaskDescription($id, $task)
	updateTaskDescription => updateTaskDescription($vars['value'], $vars['pk']);
	// TODO: Update 'Task' using Id
	
	removeEntry => deleteEntry($id)
	removeEntry => removeEntry($vars['pk']);
	// TODO: Simple delete by Id
	
	getEntryNames => getDistinctItems	
	getEntryNames => getEntryNames (json!)
	"SELECT DISTINCT Task FROM entries"
	
	getTsCodes => getDistinctTsCodes
	getTsCodes => getTsCodes (json!)
	"SELECT DISTINCT TSCode FROM entries"
*/