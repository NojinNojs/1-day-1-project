<?php
include 'functions.php';
$langData = loadLanguage();

session_start();

$answers = isset($_SESSION['answers']) ? $_SESSION['answers'] : [];
?>

<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'en'; ?>">

<head>
    <meta charset="UTF-8">
    <title><?= $langData['your_answers']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1><?= $langData['your_answers']; ?></h1>
        <?php if (!empty($answers)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= $langData['question']; ?></th>
                        <th><?= $langData['your_answer']; ?></th>
                        <th><?= $langData['correct_answer']; ?></th>
                        <th><?= $langData['status']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($answers as $index => $answer): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= $answer['question']; ?></td>
                            <td><?= $answer['options'][$answer['your_answer']]; ?></td>
                            <td><?= $answer['options'][$answer['correct_answer']]; ?></td>
                            <td><?= ($answer['your_answer'] == $answer['correct_answer']) ? $langData['correct'] : $langData['incorrect']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><?= $langData['no_answers']; ?></p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary"><?= $langData['back_home']; ?></a>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>