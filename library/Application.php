<?php

/*
 * Class manipulate application
 */

/*
 * Autload classes  
 */

function __autoload($class_name) {
    require_once $class_name . '.php';
}

class Application {

    /**
     * REQUEST_URI
     * @var type string
     */
    private $_request;

    /**
     * APPLICATION_PATH
     * @var type string
     */
    private $_path;

    /**
     * Directory application
     * @var type string
     */
    private $_dir;

    /**
     * Controller, Action, Parameters
     * @var Route
     */
    private $_route;

    public function __construct($path) {

        $this->_path = $path;

        if (isset($_SERVER['REQUEST_URI'])) {
            $this->_request = $_SERVER['REQUEST_URI'];
        }

        $this->_route = Route::getInstance();
    }

    /**
     * Get data route
     */
    private function setRoute() {

        $this->_dir = end(explode('/', $this->_path));

        $pattern = '/' . $this->_dir . '\/(?<controller>[A-Za-z]+)(\/(?<action>[A-Za-z]+))?(\/(?<params>[A-Za-z0-9\/=%.+]+))?/';
        preg_match_all($pattern, $this->_request, $matches);
        
        /*
         * Controller
         */
        if (isset($matches['controller'][0]) && strlen($matches['controller'][0]) > 1) {
            $this->_route->setController($matches['controller'][0]);
        } else {
            $this->_route->setController('index');
        }

        /*
         * Action 
         */
        if (isset($matches['action'][0]) && strlen($matches['action'][0]) > 1) {
            $this->_route->setAction($matches['action'][0]);
        } else {
            $this->_route->setAction('index');
        }

        /*
         * Parameters
         */
        $_params = $_REQUEST;

        if (isset($matches['params'][0]) && strlen($matches['params'][0]) > 1) {

            $pattern = '/([A-Za-z-]\/)([A-Za-z]+)?/';
            $params = preg_replace($pattern, '$1=$2', $matches['params'][0]);
            $params = explode('/', str_replace('/=', '=', $params));
            
            foreach ($params as $param) {
                $p = explode('=', $param, 2);
                if (isset($p[0])) {                    
                    $_params[$p[0]] = (isset($p[1]) ? $p[1] : $p[0]);
                }
            }
        }

        $this->_route->setParams($_params);
    }

    /**
     * Start application
     */
    public function run() {

        $this->setRoute();

        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();
    }

}
