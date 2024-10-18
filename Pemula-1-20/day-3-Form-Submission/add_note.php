<?php
// Ambil data dari form
$title = $_POST['title'];
$content = $_POST['content'];

// Buat array untuk catatan baru
$newNote = [
  'title' => $title,
  'content' => $content,
  'date' => date('Y-m-d H:i:s')
];

// Ambil data dari file JSON (jika ada)
$notes = json_decode(file_get_contents('notes.json'), true) ?? [];

// Tambahkan catatan baru ke array
$notes[] = $newNote;

// Simpan kembali ke file JSON
file_put_contents('notes.json', json_encode($notes));

// Redirect ke halaman utama
header('Location: index.php');
exit();
?>
