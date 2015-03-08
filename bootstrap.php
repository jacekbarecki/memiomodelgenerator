<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);


define('BASE_DIR', dirname(__FILE__));


spl_autoload_register(function($className) {
    require_once(BASE_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $className . '.php');
});

require_once(BASE_DIR . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
