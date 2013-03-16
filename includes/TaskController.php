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

if(isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
    switch($action) {
        case 'getEntryNames' : getEntryNames(); break;
        case 'getTsCodes' : getTsCodes(); break;
    }
}

function createNewTask() {
    $task = $_POST['task'];
    $tscode = $_POST['tsCode'];
    $start = time();
    DatabaseLayer::getInstance()->insertTask($tscode, $task, $start);
}

function updateTaskDescription() {
    $task = $_POST['value'];
    $id = $_POST['pk'];
    DatabaseLayer::getInstance()->updateTaskDescription($id, $task);
}

function getAllEntries() {
    $entries = DatabaseLayer::getInstance()->getAllEntries();

    $returnArray =  array();
    foreach($entries as &$value) {
        $date = date('d-m-Y', strtotime($value['Start']));
        $returnArray[$date][] = $value;
    }
    ksort($returnArray);

    return $returnArray;
}

function removeEntry() {
    $id = $_POST['pk'];
    DatabaseLayer::getInstance()->deleteEntry($id);
}

function getEntryNames() {
    $arr = DatabaseLayer::getInstance()->getDistinctItems();
    header('Content-Type: application/json');
    echo json_encode($arr);
}

function getTsCodes() {
    $arr = DatabaseLayer::getInstance()->getDistinctTsCodes();
    header('Content-Type: application/json');
    echo json_encode($arr);
}








