
                <li><a href="pages/keranjang.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="pages/favorit.php"><i class="fa-regular fa-heart"></i></a></li>
                <i class="fa-solid fa-star"></i>

CREATE DATABASE motifnesia;

USE motifnesia;

<<<<<<< HEAD
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



=======
CREATE TABLE checkout (
  id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  alamat text NOT NULL,
  pengiriman varchar(20) NOT NULL,
  pembayaran varchar(30) NOT NULL,
  total_harga decimal(12,2) NOT NULL,
  ongkir decimal(12,2) NOT NULL,
  total_bayar decimal(12,2) NOT NULL,
  status_id int(11) NOT NULL DEFAULT 1,
  created_at datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO checkout (id, user_id, alamat, pengiriman, pembayaran, total_harga, ongkir, total_bayar, status_id, created_at) VALUES
(2, 10, 'sa', 'ekonomis', 'gopay', 4500000.00, 10000.00, 4510000.00, 1, '2025-05-28 09:31:29'),
(3, 10, 'dsa', 'ekspres', 'bca', 9999999999.99, 20000.00, 9999999999.99, 1, '2025-05-28 09:32:24');

CREATE TABLE checkout_items (
  id int(11) NOT NULL,
  checkout_id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  ukuran varchar(10) NOT NULL,
  qty int(11) NOT NULL,
  harga_satuan decimal(12,2) NOT NULL,
  subtotal decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO checkout_items (id, checkout_id, product_id, ukuran, qty, harga_satuan, subtotal) VALUES
(1, 2, 16, 'L', 5, 900000.00, 4500000.00),
(2, 3, 15, 'SS', 493533, 400000.00, 9999999999.99);

CREATE TABLE favorit (
  id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO favorit (id, user_id, product_id, created_at) VALUES
(3, 1, 14, '2025-05-07 11:42:35'),
(4, 1, 15, '2025-05-07 12:10:26'),
(5, 10, 15, '2025-05-25 19:08:16'),
(6, 10, 16, '2025-05-25 19:15:44');

CREATE TABLE keranjang (
  id int(11) NOT NULL,
  user_id int(11) DEFAULT NULL,
  product_id int(11) DEFAULT NULL,
  ukuran varchar(10) DEFAULT NULL,
  qty int(11) DEFAULT 1,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO keranjang (id, user_id, product_id, ukuran, qty, created_at, updated_at) VALUES
(3, 1, 16, NULL, 3, '2025-05-06 19:46:44', '2025-05-07 11:42:18'),
(4, 1, 13, NULL, 6, '2025-05-06 20:42:47', '2025-05-07 14:13:20'),
(5, 5, 13, NULL, 2, '2025-05-06 20:52:16', '2025-05-06 20:52:18'),
(6, 5, 14, NULL, 3, '2025-05-06 20:52:22', '2025-05-06 20:52:24'),
(7, 1, 14, NULL, 3, '2025-05-07 11:42:10', '2025-05-07 11:42:23'),
(8, 1, 15, NULL, 2, '2025-05-07 12:10:31', '2025-05-08 18:39:15'),
(17, 10, 15, 'M', 142, '2025-05-26 19:06:26', '2025-05-26 19:38:27');



CREATE TABLE produk (
  id int(11) NOT NULL,
  gambar varchar(255) DEFAULT NULL,
  nama_produk varchar(100) DEFAULT NULL,
  harga decimal(10,2) DEFAULT NULL,
  material varchar(100) DEFAULT NULL,
  proses varchar(100) DEFAULT NULL,
  sku varchar(50) DEFAULT NULL,
  tags varchar(255) DEFAULT NULL,
  stok int(11) DEFAULT 0,
  kategori varchar(50) DEFAULT NULL,
  jenis_lengan varchar(50) DEFAULT NULL,
  terjual varchar(255) DEFAULT NULL,
  deskripsi varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT produk (dipersingkat agar tidak terlalu panjang)
-- Salin ulang INSERT produk kalau perlu data lengkap

CREATE TABLE status_log (
  id int(11) NOT NULL,
  checkout_id int(11) NOT NULL,
  status_id int(11) NOT NULL,
  waktu datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO status_log (id, checkout_id, status_id, waktu) VALUES
(1, 2, 1, '2025-05-28 09:31:29'),
(2, 3, 1, '2025-05-28 09:32:24');

CREATE TABLE status_transaksi (
  id int(11) NOT NULL,
  nama_status varchar(20) NOT NULL,
  keterangan varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO status_transaksi (id, nama_status, keterangan) VALUES
(1, 'Menunggu Konfirmasi', NULL),
(2, 'Diproses', NULL),
(3, 'Dikirim', NULL),
(4, 'Selesai', NULL);

CREATE TABLE users (
  id int(11) NOT NULL,
  username varchar(50) NOT NULL,
  email varchar(100) NOT NULL,
  nomor_hp varchar(20) DEFAULT NULL,
  tanggal_lahir date DEFAULT NULL,
  jenis_kelamin enum('L','P') DEFAULT NULL,
  foto varchar(255) DEFAULT NULL,
  role enum('user','admin') DEFAULT NULL,
  password varchar(255) NOT NULL,
  nama_lengkap varchar(100) DEFAULT NULL,
  secret_question text NOT NULL,
  secret_answer text NOT NULL,
  created_at datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT users (sudah ada di data awal)

-- Primary keys & indexing
ALTER TABLE checkout ADD PRIMARY KEY (id), ADD KEY user_id (user_id), ADD KEY status_id (status_id);
ALTER TABLE checkout_items ADD PRIMARY KEY (id), ADD KEY checkout_id (checkout_id), ADD KEY product_id (product_id);
ALTER TABLE favorit ADD PRIMARY KEY (id), ADD UNIQUE KEY unique_favorit (user_id, product_id), ADD KEY product_id (product_id);
ALTER TABLE keranjang ADD PRIMARY KEY (id), ADD KEY user_id (user_id), ADD KEY product_id (product_id);
ALTER TABLE produk ADD PRIMARY KEY (id);
ALTER TABLE status_log ADD PRIMARY KEY (id), ADD KEY checkout_id (checkout_id), ADD KEY status_id (status_id);
ALTER TABLE status_transaksi ADD PRIMARY KEY (id);
ALTER TABLE users ADD PRIMARY KEY (id), ADD UNIQUE KEY username (username), ADD UNIQUE KEY email (email);

-- AUTO_INCREMENTs
ALTER TABLE checkout MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE checkout_items MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE favorit MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE keranjang MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
ALTER TABLE produk MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
ALTER TABLE status_log MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE status_transaksi MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE users MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- Foreign Keys
ALTER TABLE checkout
  ADD CONSTRAINT checkout_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  ADD CONSTRAINT checkout_ibfk_2 FOREIGN KEY (status_id) REFERENCES status_transaksi (id);

ALTER TABLE checkout_items
  ADD CONSTRAINT checkout_items_ibfk_1 FOREIGN KEY (checkout_id) REFERENCES checkout (id) ON DELETE CASCADE,
  ADD CONSTRAINT checkout_items_ibfk_2 FOREIGN KEY (product_id) REFERENCES produk (id);

ALTER TABLE favorit
  ADD CONSTRAINT favorit_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  ADD CONSTRAINT favorit_ibfk_2 FOREIGN KEY (product_id) REFERENCES produk (id) ON DELETE CASCADE;

ALTER TABLE keranjang
  ADD CONSTRAINT keranjang_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id),
  ADD CONSTRAINT keranjang_ibfk_2 FOREIGN KEY (product_id) REFERENCES produk (id);

ALTER TABLE status_log
  ADD CONSTRAINT status_log_ibfk_1 FOREIGN KEY (checkout_id) REFERENCES checkout (id) ON DELETE CASCADE,
  ADD CONSTRAINT status_log_ibfk_2 FOREIGN KEY (status_id) REFERENCES status_transaksi (id);

COMMIT;
>>>>>>> 3dedeeb571807fd51f5441116d07abb04622f075
