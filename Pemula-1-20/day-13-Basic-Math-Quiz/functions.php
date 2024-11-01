<?php
function loadLanguage() {
    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = $_GET['lang'];
    }

    $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
    $file = "lang/$lang.php";

    if (file_exists($file)) {
        return include($file);
    } else {
        return include("lang/en.php");
    }
}
?>
