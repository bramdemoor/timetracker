<?php

namespace Controllers;

use Models\EntriesModel,
    Views\View;

class EntriesController
{
    public $template = 'Entries';

    public function index($vars)
    {
        $model = new EntriesModel();
        $entries = $model->getAllEntries();
        $view = new View($this->template);
        $view->assign('entries', $entries);
    }

    public function createNewEntry($vars) {
        $tscode = $vars['tsCode'];
        $description = $vars['description'];
        $start = time();
        $model = new EntriesModel();
        $model->createNewEntry($tscode, $description, $start);
    }

    function updateTaskDescription($vars) {
        $task = $vars['value'];
        $id = $vars['pk'];
        $model = new EntriesModel();
        $model->updateTaskDescription($task, $id);
    }

    function removeEntry($vars) {
        $id = $vars['pk'];
        $model = new EntriesModel();
        $model->removeEntry($id);
    }

    function getEntryNames() {
        $model = new EntriesModel();
        $arr = $model->getEntryNames();
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    function getTsCodes() {
        $model = new EntriesModel();
        $arr = $model->getTsCodes();
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
}
