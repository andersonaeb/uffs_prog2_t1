<?php

/*
 * Resources controller
 */

class Controller {

    /**
     * Controller, Action, Parameters
     * @var Route
     */
    private $_route;

    /**
     * Object View
     * @var View
     */
    public $_view;

    public function __construct() {

        $this->_route = Route::getInstance();

        $this->_view = View::getInstance();
    }

    /**
     * Set title page
     * @param type $title
     */
    public function setTitle($title) {
        $this->_view->setTitle($title);
    }

    /**
     * Get filename layout
     * @return type string
     */
    public function getLayout() {
        return $this->_view->getLayout();
    }

    /**
     * Set filename layout
     * @param type $layout     
     */
    public function setLayout($layout) {
        $this->_view->setLayout($layout);
    }

    /**
     * Get all params url
     * @return type array
     */
    public function getParams() {
        return $this->_route->getParams();
    }

    /**
     * Get parameter url
     * @param type $param
     * @return type string
     */
    public function getParam($param) {
        return $this->_route->getParam($param);
    }

    /**
     * Redirect page
     * @param type $page
     */
    public function _redirect($page) {
        header('Location: ' . $this->_view->baseUrl($page));
    }

    /**
     * Verify request is post
     * @return boolean
     */
    public function isPost() {
        if (count($_POST) > 0)
            return true;
        else
            return false;
    }

}