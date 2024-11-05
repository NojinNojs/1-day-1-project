<?php
session_start();
$_SESSION['tasks'] = [];
header('Location: index.php');
exit;
?>
