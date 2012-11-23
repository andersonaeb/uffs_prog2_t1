<?php

class CustomController extends Controller {

    /**
     * Object class Auth
     * @var Auth
     */
    public $_auth;

    public function __construct() {

        parent::__construct();

        $this->_auth = new Auth();

        $this->_view->setSuffixTitle('Tic Tac Toe');
    }

}