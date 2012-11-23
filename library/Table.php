<?php

/**
 * Class for a data set
 */

class Table extends Model {    
    
    /**
     * Lines the "table"
     * @var type 
     */
    protected $_rows;
    /**
     * Construtor
     * @param type $name
     */
    public function __construct ($name) {                
        parent::__construct(array('name'=>$name));
    }
    /*
     * Add the row in table
     */
    public function addRow (Model $obj) {
        $this->_rows[] = $obj;        
    }
    /**
     * Return row the table
     * @return type
     */
    public function getRows () {
        return $this->_rows;
    }    
}