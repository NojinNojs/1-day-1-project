<?php
// Data statis untuk username dan password
$valid_username = "nojin";
$valid_password = "gamonbrutal";

// Cek apakah form sudah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data username dan password dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username dan password sesuai
    if ($username === $valid_username && $password === $valid_password) {
        // Jika sesuai, redirect ke halaman success (atau bisa ke halaman lain)
        header("Location: success.php");
        exit;
    } else {
        // Jika tidak sesuai, tampilkan error dan kembali ke form login
        $error_message = "Username or password wrong!";
        header("Location: index.php?error=" . urlencode($error_message));
        exit;
    }
} else {
    // Jika tidak diakses melalui POST, redirect kembali ke halaman login
    header("Location: index.php");
    exit;
}
