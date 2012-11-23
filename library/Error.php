<?php

/*
 * Errors controller
 */

class Error {
    
    /*
     * Type errors
     */
    const MESSAGE = 0;
    const CONTROLLER = 1;
    const ACTION = 2;
    const LAYOUT = 3;
    const VIEW = 4;

    /**
     * Object class Route
     * @var Route
     */
    private $_route;

    /**
     * Code error
     * @var type int
     */
    private $_code;

    /**
     * Message 
     * @var type string
     */
    private $_message;

    /**
     * Title the page error
     * @var type string
     */
    public $title;

    public function __construct($code, $message = null) {

        $this->_route = Route::getInstance();

        $this->_code = $code;

        if (!is_null($message))
            $this->_message = $message;

        $this->title = 'An error occurred';

        $this->render();
    }

    /**
     * Get the message
     * @return string
     */
    public function getMessage() {

        switch ($this->_code) {
            case self::MESSAGE:
                $message = $this->_message;
                break;
            case self::CONTROLLER:
                $message = 'Invalid controller specified (' . $this->_route->getController() . ').';
                break;
            case self::ACTION:
                $message = 'Action "' . $this->_route->getAction() . '" does not exist in controller "' . $this->_route->getController() . '".';
                break;
            case self::LAYOUT:
                $message = 'Layout file "' . View::getInstance()->getLayout() . '" not found in "views/layouts/' . View::getInstance()->getLayout() . '".';
                break;
            case self::VIEW:
                $file = strtolower($this->_route->getAction()) . '.phtml';
                $message = 'View file "' . $file . '" not found in "views/scripts/' . strtolower($this->_route->getController()) . '/' . $file . '".';
                break;
            default:
                $message = 'Unknown Error';
        }

        return $message;
    }

    /**
     * Show de error page
     */
    public function render() {
        $view = 'views/layouts/error.phtml';

        if (file_exists($view)) {
            include $view;
        } else {
            die('File layout "error.phtml" not found');
        }
        
        exit;
    }

}

?>
