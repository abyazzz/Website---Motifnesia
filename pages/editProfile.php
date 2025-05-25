<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: halamanlogin2.php");
    exit;
}

require '../functions/function.php';
$id = $_SESSION['user_id'];

// Ambil data user
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Proses jika form di-submit
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nomor_hp = $_POST['nomor_hp'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nama_lengkap = $_POST['nama_lengkap'];

    // =====================================
    // ======= HANDLE FILE UPLOAD ==========
    // =====================================
    $uploadDir = '../asstes/uploads/';
    $newFileName = $user['foto']; // default: nama file lama

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $fileSize = $_FILES['foto']['size'];
        $fileType = $_FILES['foto']['type'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // validasi ekstensi & size (max 10MB)
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowedExt) && $fileSize <= 10 * 1024 * 1024) {
            // buat nama unik
            $newFileName = uniqid('foto_') . '.' . $ext;
            $destPath = $uploadDir . $newFileName;

            // pindah file
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // hapus file lama jika ada dan berbeda
                if (!empty($user['foto']) && file_exists($uploadDir . $user['foto'])) {
                    unlink($uploadDir . $user['foto']);
                }
            } else {
                echo "Gagal memindahkan file.";
            }
        } else {
            echo "Format gambar tidak diperbolehkan atau ukuran terlalu besar.";
        }

    }
    // =====================================
    // ===== END FILE UPLOAD HANDLER =======
    // =====================================

    // Update ke database
    $update_query = "UPDATE users SET username = '$username', nama_lengkap = '$nama_lengkap', email = '$email', nomor_hp = '$nomor_hp', tanggal_lahir = '$tanggal_lahir', jenis_kelamin = '$jenis_kelamin', foto = '$newFileName' WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        echo "Profil berhasil diperbarui!";
        // Redirect ke halaman profil setelah update
        header("Location: profileUser.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profil</title>
  <link rel="stylesheet" href="profileUser.css" />
  <link rel="stylesheet" href="asstes/css/editProf.css" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

  <div class="container">
    <h3>Edit Profil</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="nomor_hp" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="<?= htmlspecialchars($user['nomor_hp']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($user['tanggal_lahir']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="L" <?= $user['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?= $user['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Profil</label><br>
            <?php if (!empty($user['foto'])): ?>
                <img src="uploads/<?= htmlspecialchars($user['foto']); ?>" alt="Foto Lama" width="100"><br>
            <?php endif; ?>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
        <button><a href="profileUser.php">Close</a></button>
    </form>
    
  </div>

  <?php require '../asstes/header-footer/footer.php'; ?>

</body>
</html>
