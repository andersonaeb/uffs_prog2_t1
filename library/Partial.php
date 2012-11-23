<?php

/*
 * Generate de partial view
 */

class Partial {

    /**
     * Parameters view
     * @var type array
     */
    private $_params;

    /**
     * Filename view
     * @var type string
     */
    private $_view;
    
    /**
     * Route
     * @var Route
     */
    private $_route;

    public function __construct($view, $params = array()) {

        $this->_view = $view;

        $this->_params = $params;
        
        $this->_route = Route::getInstance();
    }

    public function __get($name) {
        if (isset($this->_params[$name]))
            return $this->_params[$name];
        else
            return null;
    }

    public function __toString() {

        /*
         * View
         */

        $view = 'views/scripts/' . $this->_view;

        if (file_exists($view)) {
            ob_start();
            include $view;

            $content = ob_get_clean();
        } else {
            new Error(Error::MESSAGE, 'View file "' . $view . '" not found in "views/scripts/' . $view . '".');
        }

        return $content;
    }

    public function baseUrl($file) {

        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/' . end(explode('/', APPLICATION_PATH));

        return $host . '/' . $file;
    }
    
    public function getAction()
    {
        return $this->_route->getAction();
    }
}

?>
