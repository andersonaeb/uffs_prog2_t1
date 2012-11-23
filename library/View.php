<?php

/*
 * Class to control view
 */

class View {

    /**
     * View
     * @var View
     */
    public static $_view;

    /**
     * Filename layout
     * @var type string
     */
    private $_layout = 'default.phtml';

    /**
     * Controller, Action, Parameters
     * @var Route
     */
    private $_route;

    /**
     * Title the page
     * @var type string
     */
    private $_title;

    /**
     * Suffix the title page
     * @var type string
     */
    private $_suffix_title;

    /**
     * Separator character title
     * @var type string
     */
    private $_title_separator = '|';

    /**
     * Content the view
     * @var type string
     */
    private $_content;

    /**
     * Variables the view
     * @var type array
     */
    private $_variables;

    public function __set($name, $value) {
        $this->_variables[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->_variables[$name])) {
            return $this->_variables[$name];
        }
    }

    public function __construct() {
        $this->_route = Route::getInstance();
    }

    public static function getInstance() {
        if (is_null(self::$_view)) {
            self::$_view = new View();
        }

        return self::$_view;
    }

    public function getLayout() {
        return $this->_layout;
    }

    public function setLayout($layout) {
        $this->_layout = $layout;
    }

    public function getTitle() {

        $title = $this->_title;

        if (!is_null($this->_title) && !is_null($this->_suffix_title))
            $title .= ' ' . $this->_title_separator . ' ';

        if (!is_null($this->_suffix_title))
            $title .= $this->_suffix_title;

        return $title;
    }

    public function setTitle($title) {
        $this->_title = $title;
    }

    public function setSuffixTitle($suffix_title) {
        $this->_suffix_title = $suffix_title;
    }

    public function setTittleSeparator($title_separator) {
        $this->_title_separator = $title_separator;
    }

    /**
     * Render layout and view
     */
    public function render() {

        /*
         * View
         */
        $controller = strtolower($this->_route->getController());
        $action = strtolower($this->_route->getAction());

        $view = 'views/scripts/' . $controller . '/' . $action . '.phtml';

        if (file_exists($view)) {
            ob_start();
            include $view;

            $this->_content = ob_get_clean();
        } else {
            new Error(Error::VIEW);
        }

        /*
         * Layout
         */
        $file = 'views/layouts/' . $this->_layout;

        if (file_exists($file)) {
            include $file;
        } else {
            new Error(Error::LAYOUT);
        }
    }

    public function getController()
    {
        return $this->_route->getController();
    }
    
    public function getAction()
    {
        return $this->_route->getAction();
    }
    
    public function getContent() {
        return $this->_content;
    }

    public function css($file) {
        return '<link rel="stylesheet" type="text/css" href="' . $this->baseUrl('public/css/' . $file) . '" />';
    }

    public function baseUrl($file) {

        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/' . end(explode('/', APPLICATION_PATH));

        return $host . '/' . $file;
    }

    public function partial($view, $params = array()) {

        $partial = new Partial($view, $params);

        return $partial;
    }

}