<?php

define("ACCEPT_LANG", [
    'it' => 'it_IT.utf8',
    'en' => 'en_GB.utf8',
    //'de' => 'de_DE.utf8',
    //'fr' => 'fr_FR.utf8'
]);

define("LANGUAGES", [
    "it" => ["Italiano", 100],
    "en" => ["English", 20]
]);

$lang = "it";
if (isset($_GET["lang"])) {
    $lang = $_GET["lang"];
} elseif (isset($_SESSION["lang"])) {
    $lang = $_SESSION["lang"];
} elseif (
    isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])
    && in_array($_SERVER['HTTP_ACCEPT_LANGUAGE'], ACCEPT_LANG)
) {
    $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
}
$_SESSION["lang"] = $lang;

setlocale(LC_ALL, ACCEPT_LANG[$lang]);
bindtextdomain("sentinel2020", BASE_PATH . "resources/locale");
textdomain("sentinel2020");
