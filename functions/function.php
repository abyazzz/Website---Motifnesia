<?php

    require 'koneksi.php';sasa

    function query($query) { //menampilkan data
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function tambahProduk($data, $file) {
        global $conn;
    
        // Ambil data dari form dan amankan
        $nama_produk   = htmlspecialchars($data["nama_produk"]  );
        $harga         = htmlspecialchars($data["harga"]        );
        $material      = htmlspecialchars($data["material"]     );
        $proses        = htmlspecialchars($data["proses"]       );
        $sku           = htmlspecialchars($data["sku"]          );
        $tags          = htmlspecialchars($data["tags"]         );
        $stok          = htmlspecialchars($data["stok"]         );
        $kategori      = htmlspecialchars($data["kategori"]     );
        $jenis_lengan  = htmlspecialchars($data["jenis_lengan"] );
        $deskripsi     = htmlspecialchars($data["deskripsi"]    );
    
        // Upload Gambar
        $namaFile = $file['gambar']['name'];
        $tmpName  = $file['gambar']['tmp_name'];
        $error    = $file['gambar']['error'];
    
        // Validasi gambar
        if ($error === 4) {
            echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
            return false;
        }
    
        // Validasi ekstensi gambar
        $ekstensiValid = ['jpg', 'jpeg', 'png'];
        $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        if (!in_array($ekstensi, $ekstensiValid)) {
            echo "<script>alert('Yang diupload harus gambar (jpg, jpeg, png)!');</script>";
            return false;
        }
    
        // Generate nama file baru biar unik
        $namaBaru = uniqid() . '.' . $ekstensi;
    
        // Pindahkan file ke folder img/
        $targetDir = __DIR__ . '/../asstes/img/';
        if (!move_uploaded_file($tmpName, $targetDir . $namaBaru)) {
            echo "<script>alert('Gagal mengupload gambar!');</script>";
            return false;
        }
    
        // Simpan data ke database
        $query = "INSERT INTO produk 
                    (gambar, nama_produk, harga, material, proses, sku, tags, stok, kategori, jenis_lengan, deskripsi )
                  VALUES 
                    ('$namaBaru', '$nama_produk', '$harga', '$material', '$proses', '$sku', '$tags', '$stok', '$kategori', '$jenis_lengan', '$deskripsi ')";
    
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "<script>alert('Gagal menyimpan data: " . mysqli_error($conn) . "');</script>";
            return false;
        }
    
        return mysqli_affected_rows($conn);
    }
    
    function hapusProduk($id) {
        global $conn;
        mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
        return mysqli_affected_rows($conn);
    }
    
    function tambahStok($id) {
        global $conn;
        mysqli_query($conn, "UPDATE produk SET stok = stok + 1 WHERE id = $id");
        return mysqli_affected_rows($conn);
    }

    function editProduk($data, $file) {
        global $conn;
    
        // Ambil data dari form
        $id            = htmlspecialchars($data["id"]);
        $nama_produk   = htmlspecialchars($data["nama_produk"]);
        $harga         = htmlspecialchars($data["harga"]);
        $material      = htmlspecialchars($data["material"]);
        $proses        = htmlspecialchars($data["proses"]);
        $sku           = htmlspecialchars($data["sku"]);
        $tags          = htmlspecialchars($data["tags"]);
        $stok          = htmlspecialchars($data["stok"]);
        $kategori      = htmlspecialchars($data["kategori"]);
        $jenis_lengan  = htmlspecialchars($data["jenis_lengan"]);
        $gambarLama    = htmlspecialchars($data["gambarLama"]);
    
        // Cek apakah user upload gambar baru
        if ($file['gambar']['error'] === 4) {
            // Tidak upload gambar baru, pakai gambar lama
            $namaBaru = $gambarLama;
        } else {
            // Upload gambar baru
            $namaFile = $file['gambar']['name'];
            $tmpName  = $file['gambar']['tmp_name'];
    
            $ekstensiValid = ['jpg', 'jpeg', 'png'];
            $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            if (!in_array($ekstensi, $ekstensiValid)) {
                echo "<script>alert('Yang diupload harus gambar (jpg, jpeg, png)!');</script>";
                return false;
            }
    
            $namaBaru = uniqid() . '.' . $ekstensi;
    
            // Pindahkan file ke folder img/
            if (!move_uploaded_file($tmpName, __DIR__ . '/../asstes/img/' . $namaBaru)) {
                echo "<script>alert('Gagal mengupload gambar!');</script>";
                return false;
            }
    
            // Optional: hapus gambar lama dari folder jika perlu
            if (file_exists(__DIR__ . '/../img/' . $gambarLama)) {
                unlink(__DIR__ . '/../img/' . $gambarLama);
            }
        }
    
        // Update data ke database
        $query = "UPDATE produk SET 
                    gambar        = '$namaBaru',
                    nama_produk   = '$nama_produk',
                    harga         = '$harga',
                    material      = '$material',
                    proses        = '$proses',
                    sku           = '$sku',
                    tags          = '$tags',
                    stok          = '$stok',
                    kategori      = '$kategori',
                    jenis_lengan  = '$jenis_lengan'
                  WHERE id = $id";
    
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "<script>alert('Gagal menyimpan data: " . mysqli_error($conn) . "');</script>";
            return false;
        }
    
        return mysqli_affected_rows($conn);
    }
    
    
    function filter($kategori, $jenis_lengan) {
        global $conn;
    
        $query = "SELECT * FROM produk WHERE 1";
    
        if (!empty($kategori)) {
            $query .= " AND kategori = '$kategori'";
        }
    
        if (!empty($jenis_lengan)) {
            $query .= " AND jenis_lengan = '$jenis_lengan'";
        }

        
    
        $result = mysqli_query($conn, $query);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    function filterProdukByHarga($min, $max) {
        global $conn;
        $query = "SELECT * FROM produk WHERE harga BETWEEN $min AND $max";
        $result = mysqli_query($conn, $query);
        $produk = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $produk[] = $row;
        }
        return $produk;
    }

    function register($data) {
        global $conn;
    
        $username = htmlspecialchars($data["username"]);
        $email = htmlspecialchars($data["email"]);
        $password = htmlspecialchars($data["password"]);
        $secret_question = $data["secret_question"];
        $secret_answer = htmlspecialchars($data["secret_answer"]);
    
        // Cek apakah username sudah ada
        $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
        if (mysqli_fetch_assoc($result)) {
            echo "<script>alert('Username sudah terdaftar!');</script>";
            return false;
        }
    
        // Cek apakah email sudah ada
        $result = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_fetch_assoc($result)) {
            echo "<script>alert('Email sudah terdaftar!');</script>";
            return false;
        }
    
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
        // Simpan data ke DB
        $query = "INSERT INTO users (username, email, password, secret_question, secret_answer) 
                  VALUES ('$username', '$email', '$passwordHash', '$secret_question', '$secret_answer')";
        mysqli_query($conn, $query);
    
        return mysqli_affected_rows($conn);
    }

    function login($data) {
        global $conn;
    
        $username = htmlspecialchars($data['username']);
        $password = $data['password'];
    
        $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $query);
       
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
    
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['profile_picture'] = $user['foto']; 
    
                return true;
            }
        }
        return false;
    }
?>