<?php
// Ambil ID catatan yang akan dihapus
$noteId = $_POST['note_id'];

// Ambil data catatan dari file JSON
$notes = json_decode(file_get_contents('notes.json'), true) ?? [];

// Hapus catatan berdasarkan ID
if (isset($notes[$noteId])) {
  unset($notes[$noteId]);
}

// Simpan perubahan ke file JSON
file_put_contents('notes.json', json_encode(array_values($notes)));

// Redirect ke halaman utama
header('Location: index.php');
exit();
?>
