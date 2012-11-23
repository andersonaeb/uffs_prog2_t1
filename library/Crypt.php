<?php

/*
 * Class for encryption
 */

class Crypt {

    private $key = 'tb1uffsaa';

    /**
     * Encrypt a string
     * @param type $string
     * @return type string
     */
    public function encrypt($string) {
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->key), $string, MCRYPT_MODE_CBC, md5(md5($this->key))));
        return base64_encode($encrypted);
    }

    /**
     * Decrypt a string
     * @param type $string
     * @return type string
     */
    public function decrypt($string) {
        $string = base64_decode($string);
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($this->key))), "\0");
        return $decrypted;
    }

}

?>
