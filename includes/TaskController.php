<?php

include('DatabaseLayer.php');

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'createNewTask' : createNewTask();break;
        case 'updateTaskDescription' : updateTaskDescription();break;
        case 'removeEntry' : removeEntry(); break;
    }
}

function createNewTask() {
    $task = $_POST['task'];
    $start = time();
    DatabaseLayer::getInstance()->insertTask($task, $start);
}

function updateTaskDescription() {
    $task = $_POST['value'];
    $id = $_POST['pk'];
    DatabaseLayer::getInstance()->updateTaskDescription($id, $task);
}

function getAllEntries() {
    return DatabaseLayer::getInstance()->getAllEntries();
}

function removeEntry() {
    $id = $_POST['pk'];
    DatabaseLayer::getInstance()->deleteEntry($id);
}








