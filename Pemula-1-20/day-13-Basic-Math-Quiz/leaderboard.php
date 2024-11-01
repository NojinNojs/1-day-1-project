<?php
include 'functions.php';
$langData = loadLanguage();

$scores = json_decode(file_get_contents('scores.json'), true);

// Urutkan skor dari yang tertinggi
usort($scores, function ($a, $b) {
    return $b['score'] - $a['score'] ?: $a['time'] - $b['time'];
});
?>

<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'en'; ?>">

<head>
    <meta charset="UTF-8">
    <title><?= $langData['leaderboard']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1><?= $langData['leaderboard']; ?></h1>
        <?php if (!empty($scores)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= $langData['username'] ?? 'Username'; ?></th>
                        <th><?= $langData['score'] ?? 'Score'; ?></th>
                        <th><?= $langData['time_spent'] ?? 'Time Spent'; ?></th>
                        <th><?= $langData['difficulty'] ?? 'Difficulty'; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($scores as $index => $score): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($score['username'] ?? 'Anonymous'); ?></td>
                            <td><?= $score['score'] ?? '0'; ?></td>
                            <td><?= isset($score['time']) ? gmdate("i:s", $score['time']) : '00:00'; ?></td>
                            <td><?= isset($score['difficulty']) ? ucfirst($score['difficulty']) : 'N/A'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><?= $langData['no_scores'] ?? 'No scores available.'; ?></p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary"><?= $langData['back_home'] ?? 'Back to Homepage'; ?></a>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>