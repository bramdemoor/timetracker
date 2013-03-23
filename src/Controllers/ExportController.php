<?php

namespace Controllers;

use Models\ExportModel,
    Views\View,
    DateTime;

class ExportController
{
    public $template = 'Export';

    public function index($vars)
    {
        $view = new View($this->template);
    }

    public function all($vars)
    {
        $fileName = date_format(new DateTime(), 'd-m-y'). '-entries.csv';

        $model = new ExportModel();
        $model->exportAllEntries($fileName);

        $data = array(
            (object)array(
                'filename' => $fileName
            )
        );

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
