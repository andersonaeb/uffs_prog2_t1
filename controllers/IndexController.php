<?php

class IndexController extends CustomController {

    public function indexAction() {

        /*
         * Verify user is logged
         */

        if (!$this->_auth->isValid()) {
            $this->_redirect('login');
        } else {
            $this->_redirect('game/home/t/' . $this->getParam('t'));
        }
    }

}