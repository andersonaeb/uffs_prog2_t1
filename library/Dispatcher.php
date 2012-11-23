<?php

class Dispatcher {

    /**
     * Controller, Action, Parameters
     * @var Route
     */
    private $_route;

    /**
     * Object controller
     * @var type Controller
     */
    private $_controller;

    public function __construct() {

        $this->_route = Route::getInstance();

        $controller = ucfirst($this->getController()) . 'Controller';

        /*
         * Verify controller exists
         */

        if (file_exists(APPLICATION_PATH . '/controllers/' . $controller . '.php')) {

            $this->_controller = new $controller($this->_route);

            /*
             * Verify action exists
             */

            if (method_exists($this->_controller, $this->getAction() . 'Action')) {
                $method = $this->getAction() . 'Action';

                call_user_func(array($this->_controller, $method));
            } else {
                new Error(Error::ACTION);
            }
        } else {
            new Error(Error::CONTROLLER);
        }
    }

    public function dispatch() {

        $view = View::getInstance();
        $view->render();
    }

    public function getController() {
        return $this->_route->getController();
    }

    public function getAction() {
        return $this->_route->getAction();
    }

    public function getParams() {
        return $this->_route->getParams();
    }

}

?>
