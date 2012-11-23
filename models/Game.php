<?php

class Game extends Model {

    //put your code here

    protected $boards;
    protected $player1;
    protected $player2;
    protected $current = 0;
    protected $last = 2;

    public function __construct($params = array()) {
        parent::__construct($params);

        if (empty($params['name']) || is_null($params['name']))
            $params['name'] = uniqid();

        if (sizeof($this->boards) == 0)
            $this->createBoard();
    }

    public function createBoard() {
        $this->last = 2;
        $board = new Board();
        $this->boards[] = $board;
        $this->current = sizeof($this->boards) - 1;
    }

    public function getCurrentBoard() {
        return $this->boards[$this->current];
    }

    public function getPlayer1() {
        return $this->player1;
    }

    public function setPlayer1($player1) {
        $this->player1 = $player1;
    }

    public function getPlayer2() {
        return $this->player2;
    }

    public function setPlayer2($player2) {
        $this->player2 = $player2;
    }

    public function getLast() {
        return $this->last;
    }
    
    public function getStatusInit()
    {
        if(!is_null($this->player1) && !is_null($this->player2)) {
            return true;
        } else {
            return false;
        }
    }

    public function setLast($last) {
        $this->last = $last;
    }

}
