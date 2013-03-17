<?php

namespace Controllers;

use Models\ExportModel,
    Views\View;

class ExportController
{
    public $template = 'Export';

    public function index($vars)
    {
        $view = new View($this->template);
    }
}
