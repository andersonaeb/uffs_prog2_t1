<?php

/**
 * Collection of players
 */
require_once('Player.php');
require_once('Table.php');

class Players extends Table {

    public function __construct() {
        parent::__construct('players');
    }

    /**
     * Return the Player Object by e-mail atribute
     * @param type $email string
     * @return type Player
     */
    public function getRowByEmail($email) {
        $obj = null;

        if (sizeof($this->_rows) > 0) {
            foreach ($this->_rows as $item) {
                if ($item instanceof $item) {
                    $uemail = $item->getEmail();
                    if ($uemail == $email) {
                        $obj = $item;
                    }
                }
            }
        }

        return $obj;
    }

    /**
     * Override the addRow for verification the e-mail
     * @param Player $p
     * @throws Exception
     */
    public function addRow(Player $p) {

        if ($this->getRowByEmail($p->getEmail())) {
            throw new Exception('This email is already in use');
        }

        parent::addRow($p);
    }
    
    public function getRanking () {        
        $rows = $this->getRows();
        
        $order = array();
        
        foreach($rows as $item) {                 
            $order[] = $item;
            $points[] = $item->getPoints();
        }
        
        rsort($points);
        
        
        $ordened = array();
        
        foreach($points as $key=>$value) {
            $ordened[] = $order[$key];
        }
        
        return $ordened;        
    }

}