<?php

class GameController extends CustomController {

    /**
     * Players
     * @var Players
     */
    private $players;

    public function homeAction() {

        $this->setDefaults();

        $this->setTitle('Welcome');

        /*
         * Errors
         */
        $this->_view->errol = $this->getParam('errol');
    }

    private function setDefaults() {

        if (!$this->_auth->isValid()) {
            $this->_redirect('login');
        }

        $this->_view->header = $this->_view->partial('partials/header.phtml', array('player' => $this->_auth->getPlayer(), 'tokken' => $this->getParam('t')));

        /*
         * Tokken Player
         */
        $this->_view->tokken = $this->getParam('t');

        /*
         * Players
         */
        $this->players = new Players();
        $this->_view->players = $this->players;
    }

    public function loadAction() {

        $this->setDefaults();

        $gname = $this->getParam('gname');
        if (!is_null($gname) && strlen($gname) > 2) {

            $name = md5($gname);
            $file = APPLICATION_MODEL_PATH . '/' . $name . '.txt';

            if (!is_file($file)) {
                $this->_redirect('game/home/t/' . $this->getParam('t') . '?errol=1');
            } else {
                $this->_redirect('game/init/t/' . $this->getParam('t') . '?gname=' . $gname);
            }
        } else {
            $this->_redirect('game/home/t/' . $this->getParam('t'));
        }
    }

    public function initAction() {

        $this->setDefaults();

        /*
         * Init Players and spectators
         */
        $gname = $this->getParam('gname');
        $game = new Game(array('name' => $gname));
        $email = null;
        
        if (is_null($game->getPlayer1()) || is_null($game->getPlayer2())) {

            if (is_null($game->getPlayer1())) {

                $game->setPlayer1($this->_auth->getPlayer());
                $game->createBoard();
                $game->update();

                $this->_redirect('game/init/t/' . $this->getParam('t') . '?gname=' . $game->getName());
            } else {
                if ($game->getPlayer1()->getEmail() != $this->_auth->getPlayer()->getEmail()) {

                    $game->setPlayer2($this->_auth->getPlayer());
                    $game->update();

                    $this->_redirect('game/init/t/' . $this->getParam('t') . '?gname=' . $game->getName());
                }
            }
        } else {
            if ($game->getPlayer1()->getEmail() != $this->_auth->getPlayer()->getEmail() &&
                    $game->getPlayer2()->getEmail() != $this->_auth->getPlayer()->getEmail()) {
                $this->_view->spectator = 1;

                if ($game->getLast() == 1) {
                    $email = $game->getPlayer2()->getEmail();
                } else {
                    $email = $game->getPlayer1()->getEmail();
                }
            } else {
                $email = $this->_auth->getPlayer()->getEmail();
                
                $this->_view->spectator = 0;                
            }
        }

        /*
         * Board
         */

        if (isset($_GET['new']))
            $game->createBoard();

        $board = $game->getCurrentBoard();

        $this->_view->board = $board;

        /*
         * Game
         */
        
        if ($game->getPlayer1()->getEmail() == $email) {
            $tplayer = 1;
        } else {
            $tplayer = 2;
        }

        if (isset($_GET['l']) && isset($_GET['c'])) {
            $game->setLast($tplayer);
            $board->savePosition(intval($_GET['l']), intval($_GET['c']), $tplayer);
        }


        $win = $board->verifyIsWin();
        $last = $game->getLast();

        try {

            $obj = $this->players->getRowByEmail($this->_auth->getPlayer()->getEmail());


            if ($obj == null) {
                $this->players->addRow($this->_auth->getPlayer());
            }

            if ($win != null) {
                if ($win == 1) {
                    $email = $game->getPlayer1()->getEmail();
                } else {
                    $email = $game->getPlayer2()->getEmail();
                }

                if ($win == $tplayer) {

                    $save = $board->getSave();

                    if (!$save) {
                        $obj = $this->players->getRowByEmail($email);
                        $obj->addPoints();
                        $this->_redirect('game/init/t/' . $this->getParam('t') . '?gname=' . $this->getParam('gname'));
                    }

                    $board->setSave(true);
                }
                $win = $email;
            }
            $this->players->update();
        } catch (Exception $e) {
            
        }

        $game->update();

        $this->_view->game = $game;
        $this->_view->gname = $game->getName();
        $this->_view->last = $last;
        $this->_view->tplayer = $tplayer;
        $this->_view->win = $win;
        $this->_view->player_email = $this->_auth->getPlayer()->getEmail();
    }

}