<?php

/*
 * Login module
 */

class Auth {

    /**
     * Object class Route
     * @var Route
     */
    private $_route;

    /**
     * Tokken de login
     * @var type string
     */
    private $_tokken;

    /**
     * Object class Crypt
     * @var Crypt
     */
    private $_crypt;

    /**
     * Object class Player
     * @var Player
     */
    private $_player;

    public function __construct() {
        $this->_route = Route::getInstance();

        $this->_tokken = $this->_route->getParam('t');

        $this->_crypt = new Crypt();
    }

    public function login($user, $email) {

        $user = strtolower($user);
        $email = strtolower($email);

        $players = new Players();
        $player = $players->getRowByEmail($email);

        if (count($player) > 0) {
            if (strtolower($player->getNome()) == $user) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verify if user exists and is valid
     * @return boolean
     */
    public function isValid() {

        $isValid = false;

        if (!is_null($this->_tokken)) {

            $email = $this->_crypt->decrypt($this->_tokken);

            $players = new Players();
            $p = $players->getRowByEmail($email);

            if (count($p) > 0) {                
                $this->_player = $p;
                $isValid = true;
            }
        }

        return $isValid;
    }
    
    /**
     * Get de player object
     * @return Player
     */
    public function getPlayer()
    {
        return $this->_player;
    }

}
?>
