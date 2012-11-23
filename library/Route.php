<?php

/*
 * Control Routes
 */

class Route {

    /**
     * Controller
     * @var type string
     */
    private $_controller;

    /**
     * Action
     * @var type string
     */
    private $_action;

    /**
     * Parameters
     * @var type string
     */
    private $_params;

    /**
     * Object class Route
     * @var Route
     */
    public static $_route;

    public static function getInstance() {
        if (is_null(self::$_route)) {
            self::$_route = new Route();
        }

        return self::$_route;
    }

    public function getController() {
        return $this->_controller;
    }

    public function setController($_controller) {
        $this->_controller = $_controller;
    }

    public function getAction() {
        return $this->_action;
    }

    public function setAction($_action) {
        $this->_action = $_action;
    }

    public function getParams() {
        return $this->_params;
    }

    public function getParam($param) {

        if (isset($this->_params[$param])) {
            return $this->_params[$param];
        } else {
            return null;
        }
    }

    public function setParams($_params) {
        $this->_params = $_params;
    }

}

?>
