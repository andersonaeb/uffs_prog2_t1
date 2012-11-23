<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Board
 *
 * @author nzk
 */
class Board extends Model {

    //put your code here    
    protected $matrix;
    protected $save = false;
    
    

    public function __construct($params = array()) {
        parent::__construct($params);
        $this->matrix = array();
                
    }

    public function savePosition($line, $column, $value) {
        $this->matrix[$line][$column] = $value;
    }

    public function getPosition($line, $column) {
        return (isset($this->matrix[$line][$column]) ? $this->matrix[$line][$column] : null);
    }

    public function verifyIsWin() {

        $win = false;

        for ($i = 0; $i < sizeof($this->matrix); $i++) {
            $temp = null;
            $count = 1;
            
            if(isset($this->matrix[$i])) {
                for ($j = 0; $j < sizeof($this->matrix[$i]); $j++) {

                    if (isset($this->matrix[$i][$j]) && $this->matrix[$i][$j] != $temp) {
                        $temp = $this->matrix[$i][$j];

                    }
                    else
                        if(isset($this->matrix[$i][$j]))
                            $count++;
                }            
                if ($count >= 3) {
                    $win = $this->matrix[$i][0];
                }
            }
        }
        
        for ($i = 0; $i < 3; $i++) {
            $temp = null;
            $count = 1;

            for ($j = 0; $j < 3; $j++) {

                if (isset($this->matrix[$j][$i]) && $this->matrix[$j][$i] != $temp) {
                    $temp = $this->matrix[$j][$i];
                    
                }
                else
                    if(isset($this->matrix[$j][$i]))
                        $count++;
            }            
            if ($count >= 3) {                
                $win = $this->matrix[0][$i];
            }
        }
        
        
        if(isset($this->matrix[0][0]) && isset($this->matrix[1][1]) && isset($this->matrix[2][2]) && $this->matrix[0][0] == $this->matrix[1][1] && $this->matrix[1][1] == $this->matrix[2][2]) {
            $win = $this->matrix[0][0];
        }
      
        if(isset($this->matrix[0][2]) && isset($this->matrix[1][1]) && isset($this->matrix[2][0]) && $this->matrix[0][2] == $this->matrix[2][0] && $this->matrix[2][0] == $this->matrix[1][1]) {
            $win = $this->matrix[0][2];
        }
        
        return $win;
    }
    
    public function getSave() {
        return $this->save;
    }

    public function setSave($save) {
        $this->save = $save;
    }


    
}
