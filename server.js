var fs = require('fs');
var express = require('express');
var app = express();

app.use(express.logger('dev'));
app.use(express.static(__dirname + '/public'));

app.get('/entries', function(req, res){
  res.json([{Id:1,TSCode:'ABC123',Task:'My first entry',Start:new Date()}]);
});

app.get('/entrynames', function(req, res){
  res.json(['My first entry']);
});

app.get('/tsccodes', function(req, res){
  res.json(['ABC123']);
});

app.listen(8080);

/*
	TODO: Implement CRUD
	
	createNewEntry => createNewEntry($vars['tsCode'], $vars['description'], time());
	updateTaskDescription => updateTaskDescription($vars['value'], $vars['pk']);
	removeEntry => removeEntry($vars['pk']);
*/