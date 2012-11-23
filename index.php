<?php
ini_set('display_errors', 'on');

// Define path to application directory
define('APPLICATION_PATH', realpath(dirname(__FILE__) . ''));
define('APPLICATION_MODEL_PATH', APPLICATION_PATH . '/data');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/library'),
            realpath(APPLICATION_PATH . '/controllers'),
            realpath(APPLICATION_PATH . '/models'),
            get_include_path(),
        )));

require_once 'Application.php';

$app = new Application(APPLICATION_PATH);
$app->run();
?>