<?php

namespace Views;

class View
{
    private $data = array();

    private $render = FALSE;

    public function __construct($template)
    {
        $file = SERVER_ROOT . '/Views/' . strtolower($template) . '.php';

        if (file_exists($file))
        {
            $this->render = $file;
        }
    }

    public function assign($variable , $value)
    {
        $this->data[$variable] = $value;
    }

    public function __destruct()
    {
        $data = $this->data;
        include($this->render);
    }
}
