<?php
require_once 'config/database.php';

// VALIDASI ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php?msg=ID tidak valid");
    exit;
}

// CEK DATA ADA / TIDAK
$check = $conn->prepare("SELECT id_kategori FROM kategori WHERE id_kategori = ?");
$check->bind_param("i", $id);
$check->execute();
$check->store_result();

if ($check->num_rows == 0) {
    $check->close();
    header("Location: index.php?msg=Data tidak ditemukan");
    exit;
}
$check->close();

// PROSES DELETE
$stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    // cek berhasil benar-benar terhapus
    if ($stmt->affected_rows > 0) {
        header("Location: index.php?msg=Data berhasil dihapus");
    } else {
        header("Location: index.php?msg=Gagal menghapus data");
    }

} else {
    header("Location: index.php?msg=Terjadi kesalahan saat menghapus");
}

$stmt->close();
exit;
?>