<?php

use App\Core\App;

// DEFINIZIONE VARIABILI DIFFERENTI IN BASE AL SISTEMA
$configs = ["", ".local", ".test", ".prod"];
foreach ($configs as $id => $key) {
    if (file_exists($key) && $key != "") {
        define("CFG", $key);
        break;
    }
}
if (!defined("CFG")) {
    define("CFG", ".local");
}

App::bind('config', require 'app/settings/config' . CFG . '.php');

define("TITLE", App::get('config')['server']['title']);

define("SSL", App::get('config')['server']['SSL']);
if (SSL) {
    if (
        !(isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' ||
                $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
    ) {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}

define("BASE_PATH", App::get('config')['server']['dir']);
define("SITE_URL", App::get('config')['server']['url']);
define("SERVER", App::get('config')['server']['server']);

error_reporting(App::get('config')['server']['error_reporting']);
ini_set('display_errors', App::get('config')['server']['display_errors']);
