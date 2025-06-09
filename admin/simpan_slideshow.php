<?php
require '../functions/koneksi.php'; // pastikan path koneksi sudah bener

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Fungsi bantu untuk upload file
  function uploadFile($inputName) {
    $targetDir = "../admin/uploads_slideshow/";
    if (!file_exists($targetDir)) {
      mkdir($targetDir, 0777, true); // bikin folder kalau belum ada
    }

    $fileName = basename($_FILES[$inputName]['name']);
    $targetPath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath)) {
      return $targetPath;
    }
    return null;
  }

  // Ambil input
  $nama1 = $_POST['nama_banner_1'];
  $link1 = uploadFile('gambar_banner_1');

  $nama2 = $_POST['nama_banner_2'];
  $link2 = uploadFile('gambar_banner_2');

  $nama3 = $_POST['nama_banner_3'];
  $link3 = uploadFile('gambar_banner_3');

  // Simpan ke database (gunakan REPLACE agar id = 1 selalu diupdate)
  $query = "REPLACE INTO konten_slideshow 
            (id, nama_banner_1, link_banner_1, nama_banner_2, link_banner_2, nama_banner_3, link_banner_3) 
            VALUES (1, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ssssss", $nama1, $link1, $nama2, $link2, $nama3, $link3);

  if ($stmt->execute()) {
    echo "<script>
      alert('Konten slideshow berhasil disimpan!');
      window.location.href = '../admin/kontenStatis.php'; 
    </script>";
  } else {
    echo "<script>
      alert('Gagal menyimpan slideshow!');
      window.history.back();
    </script>";
  }
}
?>
