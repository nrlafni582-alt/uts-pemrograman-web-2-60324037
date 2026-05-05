<?php
require_once 'config/database.php';

$errors = [];

// AMBIL ID DARI GET
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php?msg=ID tidak valid");
    exit;
}

// AMBIL DATA BERDASARKAN ID
$stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

// Jika tidak ditemukan
if (!$data) {
    header("Location: index.php?msg=Data tidak ditemukan");
    exit;
}

// Set nilai awal (pre-fill)
$kode = $data['kode_kategori'];
$nama = $data['nama_kategori'];
$deskripsi = $data['deskripsi'];
$status = $data['status'];

// PROSES UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Ambil & sanitasi
    $kode = trim($_POST['kode'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $status = $_POST['status'] ?? 'Aktif';

    // VALIDASI KODE
    if (empty($kode)) {
        $errors[] = "Kode kategori wajib diisi";
    } elseif (strlen($kode) < 4 || strlen($kode) > 10) {
        $errors[] = "Kode kategori harus 4-10 karakter";
    } elseif (!preg_match('/^KAT-\d+$/', $kode)) {
        $errors[] = "Format kode harus KAT-xxx (contoh: KAT-001)";
    }

    // VALIDASI NAMA
    if (empty($nama)) {
        $errors[] = "Nama kategori wajib diisi";
    } elseif (strlen($nama) < 3) {
        $errors[] = "Nama minimal 3 karakter";
    } elseif (strlen($nama) > 50) {
        $errors[] = "Nama maksimal 50 karakter";
    }

    // VALIDASI DESKRIPSI
    if (!empty($deskripsi) && strlen($deskripsi) > 200) {
        $errors[] = "Deskripsi maksimal 200 karakter";
    }

    // VALIDASI STATUS
    if (!in_array($status, ['Aktif', 'Nonaktif'])) {
        $errors[] = "Status tidak valid";
    }

    // CEK DUPLIKASI (EXCLUDE SELF)
    if (empty($errors)) {
        $check = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ? AND id_kategori != ?");
        $check->bind_param("si", $kode, $id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $errors[] = "Kode kategori sudah digunakan";
        }
        $check->close();
    }

    // UPDATE DATA
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE kategori SET kode_kategori=?, nama_kategori=?, deskripsi=?, status=? WHERE id_kategori=?");
        $stmt->bind_param("ssssi", $kode, $nama, $deskripsi, $status, $id);

        if ($stmt->execute()) {
            header("Location: index.php?msg=Data berhasil diupdate");
            exit;
        } else {
            $errors[] = "Gagal update data";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Edit Kategori</h4>
                </div>
                <div class="card-body">

                    <!-- ERROR -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <!-- Kode -->
                        <div class="mb-3">
                            <label>Kode Kategori</label>
                            <input type="text" name="kode" class="form-control"
                                   value="<?= htmlspecialchars($kode) ?>" required>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label>Nama Kategori</label>
                            <input type="text" name="nama" class="form-control"
                                   value="<?= htmlspecialchars($nama) ?>" required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control"><?= htmlspecialchars($deskripsi) ?></textarea>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label>Status</label><br>
                            <input type="radio" name="status" value="Aktif"
                                <?= ($status == 'Aktif') ? 'checked' : '' ?>> Aktif
                            <input type="radio" name="status" value="Nonaktif"
                                <?= ($status == 'Nonaktif') ? 'checked' : '' ?>> Nonaktif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>