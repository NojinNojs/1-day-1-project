<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {
    $task = [
        'name' => $_POST['task'],
        'completed' => false
    ];
    $_SESSION['tasks'][] = $task;
}

header('Location: index.php');
exit;
?>
