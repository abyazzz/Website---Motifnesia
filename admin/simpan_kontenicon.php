<?php
require '../functions/koneksi.php';

// Folder simpan file logo
$folder = '../admin/uploads_logo/';
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

// Fungsi upload logo
function uploadLogo($fieldName, $oldPath = null) {
    global $folder;
    if (!empty($_FILES[$fieldName]['name'])) {
        $namaBaru = uniqid() . '_' . $_FILES[$fieldName]['name'];
        move_uploaded_file($_FILES[$fieldName]['tmp_name'], $folder . $namaBaru);

        // Hapus logo lama kalau ada
        if ($oldPath && file_exists($oldPath)) {
            unlink($oldPath);
        }

        return $folder . $namaBaru;
    }
    return $oldPath;
}

// Ambil input
$keranjang = $_POST['keranjang'] ?? '';
$favorit   = $_POST['favorit'] ?? '';
$rating    = $_POST['rating'] ?? '';

// Cek apakah data sudah ada
$result = mysqli_query($conn, "SELECT * FROM konten_statis LIMIT 1");
$ada = mysqli_fetch_assoc($result);

if ($ada) {
    // Kalau udah ada, update
    $logoBaru = uploadLogo('logo', $ada['logo']);

    $stmt = $conn->prepare("UPDATE konten_statis SET logo=?, keranjang=?, favorit=?, rating=?, updated_at=NOW() WHERE id=?");
    $stmt->bind_param("ssssi", $logoBaru, $keranjang, $favorit, $rating, $ada['id']);
    $stmt->execute();
} else {
    // Kalau belum ada, insert baru
    $logoBaru = uploadLogo('logo');

    $stmt = $conn->prepare("INSERT INTO konten_statis (logo, keranjang, favorit, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $logoBaru, $keranjang, $favorit, $rating);
    $stmt->execute();
}

header("Location: kontenStatis.php");
exit;
