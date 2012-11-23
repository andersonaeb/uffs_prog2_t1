<?php

/**
 * Class that persists data in text file
 */

abstract class Model {

    /**
     *
     * @var type string
     */
    private $_file;

    /**
     *
     * @var type string
     */
    protected $_name;

    /**
     * Constructor of class Model
     * 
     * @param type $params array
     */
    public function __construct($params = array()) {


        if (isset($params['name'])) {
            $this->_name = $params['name'];
        } else {
            $this->_name = strtolower(get_class($this)) . time();
        }

        $this->load();
    }

    /**
     * Create the file, verify if exists
     */
    private function createFile() {
        $name = md5($this->_name);
        $this->_file = $filename = APPLICATION_MODEL_PATH . '/' . $name . '.txt';

        if (!is_file($filename)) {
            $this->saveFile("");
        }
    }

    /**
     * Get the name game
     * @return type string
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Load the file and unserialize atributtes objects
     */
    public final function load() {
        $this->createFile();
        $content = $this->getContents();

        if (!empty($content)) {
            $content = unserialize($content);

            foreach ($content as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     *  Save the file
     * @param type $data string
     */
    private function saveFile($data) {
        $fp = fopen($this->_file, "w+");
        fwrite($fp, $data);
        fclose($fp);
    }

    /**
     *  Get the file contents in text file
     * @return type string
     */
    private function getContents() {        
        return file_get_contents($this->_file);
    }

    /**
     * Persists data in text file
     */
    public final function update() {
        $data = array();
        //
        foreach (get_class_vars(get_class($this)) as $key => $value) {
            $data[$key] = $this->$key;
        }
        //
        $this->saveFile(serialize($data));
    }

    /**
     * Remove the file in data directory
     */
    public final function delete() {
        unlink($this->_file);
    }

}
