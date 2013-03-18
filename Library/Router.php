<?php

namespace Library;

class Router
{
    const DEFAULT_CONTROLLER = "Controllers\\EntriesController";
    const DEFAULT_ACTION     = "index";

    protected $controller    = self::DEFAULT_CONTROLLER;
    protected $action        = self::DEFAULT_ACTION;
    protected $params        = array();

    public function __construct() {
        $this->parseUri();
        $this->run();
    }

    protected function parseUri() {
        $request = $_SERVER['QUERY_STRING'];

        $parsed = explode('&' , $request);

        $controller = array_shift($parsed);
        $action = array_shift($parsed);

        $params = array();
        foreach ($parsed as $argument)
        {
            list($variable , $value) = preg_split('/=/', $argument);
            $params[$variable] = urldecode($value);
        }

        foreach ($_POST as $key => $val) {
            $params[$key] = $val;
        }

        if ($controller !== '') {
            $this->setController($controller);
        }
        if (isset($action)) {

            $this->setAction($action);
        }
        if (isset($params)) {
            $this->setParams($params);
        }
    }

    public function setController($controller) {
        $controller = 'Controllers\\'. ucfirst(strtolower($controller)) . "Controller";
        if (!class_exists($controller)) {
            throw new \InvalidArgumentException(
                "The controller '$controller' has not been defined.");
        }
        $this->controller = $controller;
        return $this;
    }

    public function setAction($action) {
        $reflector = new \ReflectionClass($this->controller);
        if (!$reflector->hasMethod($action)) {
            throw new \InvalidArgumentException(
                "The controller action '$action' has been not defined.");
        }
        $this->action = $action;
        return $this;
    }

    public function setParams(array $params) {
        $this->params = $params;
        return $this;
    }

    public function run() {
        call_user_func(array(new $this->controller, $this->action), $this->params);
    }
}