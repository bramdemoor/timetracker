<?php

include('DatabaseLayer.php');
$dbLayer = DatabaseLayer::getInstance();

$task = $_POST['task'];
$start = $_POST['start'];
$dbLayer->InsertTask($task);






