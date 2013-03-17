<?php

namespace Controllers;

use Models\ReportsModel,
    Views\View;

class ReportsController
{
    public $template = 'Reports';

    public function index($vars)
    {
        $model = new ReportsModel();
        $reportData = $model->getEntriesGroupedByTask();
        $view = new View($this->template);
        $view->assign('reportData', $reportData);
    }
}
