<?php
include 'functions.php';
$langData = loadLanguage();

session_start();

if (!isset($_SESSION['score'])) {
    header('Location: index.php');
    exit();
}

// Hitung waktu yang dihabiskan
$time_spent = time() - $_SESSION['start_time'];
$minutes = floor($time_spent / 60);
$seconds = $time_spent % 60;

// Ambil nama pengguna dan tingkat kesulitan
$username = $_SESSION['username'] ?? 'Anonymous';
$difficulty = $_SESSION['difficulty'] ?? 'easy';

// Simpan skor ke leaderboard
$scores = json_decode(file_get_contents('scores.json'), true);

$scores[] = [
    'username' => $username,
    'score' => $_SESSION['score'],
    'time' => $time_spent,
    'difficulty' => $difficulty
];

// Simpan kembali ke file JSON
file_put_contents('scores.json', json_encode($scores));

// Ambil skor akhir
$score = $_SESSION['score'];

// Reset sesi
session_destroy();
?>

<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'en'; ?>">

<head>
    <meta charset="UTF-8">
    <title><?= $langData['your_score']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5 text-center">
        <h1><?= $langData['congratulations']; ?>, <?= htmlspecialchars($username); ?>!</h1>
        <p><?= $langData['your_score']; ?>: <?= $score; ?></p>
        <p><?= $langData['difficulty']; ?>: <?= ucfirst($difficulty); ?></p>
        <p><?= $langData['time_spent']; ?>: <?= $minutes; ?> <?= $langData['minutes']; ?> <?= $seconds; ?>
            <?= $langData['seconds']; ?></p>
        <a href="index.php" class="btn btn-primary"><?= $langData['back_home']; ?></a>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>