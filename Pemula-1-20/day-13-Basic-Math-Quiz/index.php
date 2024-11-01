<?php
session_start();
include 'functions.php';
$langData = loadLanguage();
?>

<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'en'; ?>">

<head>
    <meta charset="UTF-8">
    <title><?= $langData['welcome']; ?> - Test Your Math Skills</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Primary Meta Tags -->
    <meta name="title" content="Math Quiz - Test Your Math Skills">
    <meta name="description" content="Challenge yourself with our interactive math quiz! Practice basic arithmetic, algebra, and more across different difficulty levels. Perfect for students and math enthusiasts.">
    <meta name="keywords" content="math quiz, mathematics, educational game, math practice, arithmetic quiz, online quiz">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <meta property="og:title" content="Math Quiz - Test Your Math Skills">
    <meta property="og:description" content="Challenge yourself with our interactive math quiz! Practice basic arithmetic, algebra, and more across different difficulty levels. Perfect for students and math enthusiasts.">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <meta name="twitter:title" content="Math Quiz - Test Your Math Skills">
    <meta name="twitter:description" content="Challenge yourself with our interactive math quiz! Practice basic arithmetic, algebra, and more across different difficulty levels. Perfect for students and math enthusiasts.">
    
    <!-- Discord -->
    <meta name="theme-color" content="#007bff">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="welcome-section text-center">
            <h1 class="mb-4"><?= $langData['welcome']; ?></h1>
            <div class="d-grid gap-3 d-md-block">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#startQuizModal"><?= $langData['start_quiz']; ?></a>
                <a href="answers.php" class="btn btn-secondary"><?= $langData['view_answers']; ?></a>
                <a href="leaderboard.php" class="btn btn-info"><?= $langData['leaderboard']; ?></a>
                <a href="about.php" class="btn btn-light"><?= $langData['about']; ?></a>
            </div>
        </div>
    </div>

    <!-- Modal Start Quiz -->
    <div class="modal fade" id="startQuizModal" tabindex="-1" aria-labelledby="startQuizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="quiz.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="startQuizModalLabel"><?= $langData['enter_name']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label"><?= $langData['your_name']; ?></label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="difficulty" class="form-label"><?= $langData['select_difficulty']; ?></label>
                            <select class="form-select" id="difficulty" name="difficulty" required>
                                <option value="easy"><?= $langData['easy']; ?></option>
                                <option value="medium"><?= $langData['medium']; ?></option>
                                <option value="hard"><?= $langData['hard']; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><?= $langData['start_quiz']; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>