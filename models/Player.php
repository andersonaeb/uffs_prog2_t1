<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Player1
 *
 * @author nzk
 */
require_once('Model.php');

class Player extends Model {

    //put your code here
    protected $nome;
    protected $email;
    protected $points = 0;
        
    
    protected $gravatar;

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;       
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        $this->setGravatar(md5($email));
    }
    public function getGravatar() {
        return $this->gravatar;
    }

    public function setGravatar($gravatar) {
        $this->gravatar = $gravatar;
    }
    
    public function getPoints() {
        return $this->points;
    }

    public function setPoints($points) {
        $this->points = $points;
    }

    public function addPoints ()
    {
        $this->points++;
    }

}
