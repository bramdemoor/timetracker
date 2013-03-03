<?php

include('DatabaseLayer.php');

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'createNewTask' : createNewTask();break;
    }
}

function createNewTask() {
    $task = $_POST['task'];
    $start = time();
    DatabaseLayer::getInstance()->insertTask($task, $start);
}

function getAllEntries() {
    return DatabaseLayer::getInstance()->getAllEntries();
}








