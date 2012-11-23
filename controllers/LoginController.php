<?php

class LoginController extends CustomController {

    public function indexAction() {

        $this->setTitle('Login');

        $this->_view->error = $this->getParam('error');

        $this->_view->form = $this->_view->partial('login/form.phtml', array(
            'action' => $this->_view->baseUrl('login/doauth'),
            'submitValue' => 'Log In'));
    }

    public function signupAction() {

        $this->setTitle('Sign Up');

        $this->_view->error = $this->getParam('error');

        $this->_view->form = $this->_view->partial('login/form.phtml', array(
            'action' => $this->_view->baseUrl('login/dosign'),
            'submitValue' => 'Sign Up',
            'nick' => $this->getParam('nick'),
            'email' => $this->getParam('email')));
    }

    public function dosignAction() {

        if ($this->isPost()) {
            $nick = strtolower($this->getParam('nickname'));
            $email = strtolower($this->getParam('email'));

            if (strlen($nick) > 2 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $players = new Players();
                $p = $players->getRowByEmail($email);

                if (count($p) > 0) {
                    /*
                     * User already exists
                     */
                    $this->_redirect('login/signup?error=2&nick=' . $nick);
                } else {
                    $p = new Player();
                    $p->setEmail($email);
                    $p->setNome($nick);

                    $players->addRow($p);
                    $players->update();

                    $crypt = new Crypt();
                    $this->_redirect('game/home/t/' . $crypt->encrypt(strtolower($email)));
                }
            } else {
                /*
                 * Fields invalid
                 */
                $this->_redirect('login/signup?error=1&nick=' . $nick . '&email=' . $email);
            }
        } else {
            $this->_redirect('login/signup');
        }
    }

    public function doauthAction() {

        if ($this->isPost()) {

            $nickname = $this->getParam('nickname');
            $email = $this->getParam('email');

            if ($this->_auth->login($nickname, $email)) {
                $crypt = new Crypt();
                $this->_redirect('game/home/t/' . $crypt->encrypt(strtolower($email)));
            } else {
                $this->_redirect('login?error=1');
            }
        } else {
            $this->_redirect('login');
        }
    }

}