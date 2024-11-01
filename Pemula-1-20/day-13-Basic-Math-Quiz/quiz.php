<?php
include 'functions.php';
$langData = loadLanguage();

session_start();

// Menerima nama pengguna dan tingkat kesulitan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
    $_SESSION['difficulty'] = $_POST['difficulty'];
    $_SESSION['score'] = 0;
    $_SESSION['question_number'] = 0;
    $_SESSION['answers'] = [];
    $_SESSION['start_time'] = time();
}

// Pastikan nama pengguna dan tingkat kesulitan sudah diset
if (!isset($_SESSION['username']) || !isset($_SESSION['difficulty'])) {
    header('Location: index.php');
    exit();
}

// Muat pertanyaan dari JSON sesuai tingkat kesulitan
$all_questions = json_decode(file_get_contents('questions.json'), true);
$questions = array_filter($all_questions, function ($question) {
    return $question['difficulty'] == $_SESSION['difficulty'];
});

// Reset array keys setelah filter
$questions = array_values($questions);

// Cek apakah ada pertanyaan untuk tingkat kesulitan yang dipilih
if (empty($questions)) {
    echo "<p>{$langData['no_questions']}</p>";
    exit();
}

// Proses jawaban sebelumnya
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['option'])) {
    $selected_option = intval($_POST['option']);
    $current_question = $questions[$_SESSION['question_number']];
    $correct_answer = $current_question['answer'];

    // Simpan jawaban
    $_SESSION['answers'][] = [
        'question' => $current_question['question'],
        'your_answer' => $selected_option,
        'correct_answer' => $correct_answer,
        'options' => $current_question['options']
    ];

    // Periksa jawaban
    if ($selected_option == $correct_answer) {
        $_SESSION['score'] += 1;
    }

    // Tingkatkan nomor pertanyaan
    $_SESSION['question_number']++;

    // Pengecekan kuis selesai
    if ($_SESSION['question_number'] >= count($questions)) {
        header('Location: finish.php');
        exit();
    }
}

// Dapatkan pertanyaan saat ini
$current_question = $questions[$_SESSION['question_number']];
?>

<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'en'; ?>">

<head>
    <meta charset="UTF-8">
    <title><?= $langData['question']; ?> <?= $_SESSION['question_number'] + 1; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5 text-center">
        <h2 class="mt-3"><?= $langData['question']; ?> <?= $_SESSION['question_number'] + 1; ?></h2>
        <p id="timer" class="text-right"><?= $langData['time_remaining'] ?? 'Time Remaining'; ?>: 60
            <?= $langData['seconds'] ?? 'seconds'; ?>
        </p>
        <form method="post" action="quiz.php">
            <h3 class="mb-4"><?= $current_question['question']; ?></h3>
            <div class="d-grid gap-2">
                <button type="submit" name="option" value="0"
                    class="btn btn-primary quiz-option"><?= $current_question['options'][0]; ?></button>
                <button type="submit" name="option" value="1"
                    class="btn btn-success quiz-option"><?= $current_question['options'][1]; ?></button>
                <button type="submit" name="option" value="2"
                    class="btn btn-danger quiz-option"><?= $current_question['options'][2]; ?></button>
                <button type="submit" name="option" value="3"
                    class="btn btn-warning quiz-option"><?= $current_question['options'][3]; ?></button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>