<?php
require '../functions/koneksi.php';

function uploadFile($inputName, $folder = "../admin/uploads_aboutUs/") {
  if ($_FILES[$inputName]['error'] === 4) {
    return null; // tidak upload
  }

  $namaFile = $_FILES[$inputName]['name'];
  $tmp = $_FILES[$inputName]['tmp_name'];
  $ext = pathinfo($namaFile, PATHINFO_EXTENSION);
  $namaBaru = uniqid() . '.' . $ext;
  $tujuan = $folder . $namaBaru;

  if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
  }

  move_uploaded_file($tmp, $tujuan);
  return $tujuan;
}

// Ambil input
$desc_ttg_kami = $_POST['desc_ttg_kami'] ?? '';
$desc_visi_misi = $_POST['desc_visi_misi'] ?? '';
$desc_nilai = $_POST['desc_nilai'] ?? '';
$sejarah_batik = $_POST['sejarah_batik'] ?? '';

// Upload file jika ada
$bg_banner = uploadFile('bg_banner');
$img_ttg_kami = uploadFile('img_ttg_kami');
$img_visi_misi = uploadFile('img_visi_misi');
$img_nilai = uploadFile('img_nilai');

// Cek apakah data sudah ada
$cek = mysqli_query($conn, "SELECT * FROM about_us LIMIT 1");
$data = mysqli_fetch_assoc($cek);

if (!$data) {
  // INSERT
  $query = "INSERT INTO about_us (
    bg_banner, img_ttg_kami, desc_ttg_kami, img_visi_misi, desc_visi_misi,
    img_nilai, desc_nilai, sejarah_batik
  ) VALUES (
    '$bg_banner', '$img_ttg_kami', '$desc_ttg_kami', '$img_visi_misi', '$desc_visi_misi',
    '$img_nilai', '$desc_nilai', '$sejarah_batik'
  )";
} else {
  // UPDATE
  $id = $data['id'];

  // Ganti file jika ada yang baru, kalau enggak pakai file lama
  $bg_banner = $bg_banner ?? $data['bg_banner'];
  $img_ttg_kami = $img_ttg_kami ?? $data['img_ttg_kami'];
  $img_visi_misi = $img_visi_misi ?? $data['img_visi_misi'];
  $img_nilai = $img_nilai ?? $data['img_nilai'];

  $query = "UPDATE about_us SET 
    bg_banner = '$bg_banner',
    img_ttg_kami = '$img_ttg_kami',
    desc_ttg_kami = '$desc_ttg_kami',
    img_visi_misi = '$img_visi_misi',
    desc_visi_misi = '$desc_visi_misi',
    img_nilai = '$img_nilai',
    desc_nilai = '$desc_nilai',
    sejarah_batik = '$sejarah_batik'
  WHERE id = $id";
}

mysqli_query($conn, $query);

// Redirect balik ke kontenStatis.php
header("Location: kontenStatis.php?status=sukses");
exit;
