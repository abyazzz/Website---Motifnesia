
CREATE DATABASE Motifnesia;


CREATE DATABASE motifnesia;

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `pengiriman` varchar(20) NOT NULL,
  `pembayaran` varchar(30) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `ongkir` decimal(12,2) NOT NULL,
  `total_bayar` decimal(12,2) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `checkout` (`id`, `user_id`, `alamat`, `pengiriman`, `pembayaran`, `total_harga`, `ongkir`, `total_bayar`, `status_id`, `created_at`) VALUES
(2, 10, 'sa', 'ekonomis', 'gopay', 4500000.00, 10000.00, 4510000.00, 1, '2025-05-28 09:31:29'),
(3, 10, 'dsa', 'ekspres', 'bca', 9999999999.99, 20000.00, 9999999999.99, 1, '2025-05-28 09:32:24');


CREATE TABLE `checkout_items` (
  `id` int(11) NOT NULL,
  `checkout_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ukuran` varchar(10) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `checkout_items` (`id`, `checkout_id`, `product_id`, `ukuran`, `qty`, `harga_satuan`, `subtotal`) VALUES
(1, 2, 16, 'L', 5, 900000.00, 4500000.00),
(2, 3, 15, 'SS', 493533, 400000.00, 9999999999.99);



CREATE TABLE `favorit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `favorit` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(3, 1, 14, '2025-05-07 11:42:35'),
(4, 1, 15, '2025-05-07 12:10:26'),
(5, 10, 15, '2025-05-25 19:08:16'),
(6, 10, 16, '2025-05-25 19:15:44');



CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `ukuran` varchar(10) DEFAULT NULL,
  `qty` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `keranjang` (`id`, `user_id`, `product_id`, `ukuran`, `qty`, `created_at`, `updated_at`) VALUES
(3, 1, 16, NULL, 3, '2025-05-06 19:46:44', '2025-05-07 11:42:18'),
(4, 1, 13, NULL, 6, '2025-05-06 20:42:47', '2025-05-07 14:13:20'),
(5, 5, 13, NULL, 2, '2025-05-06 20:52:16', '2025-05-06 20:52:18'),
(6, 5, 14, NULL, 3, '2025-05-06 20:52:22', '2025-05-06 20:52:24'),
(7, 1, 14, NULL, 3, '2025-05-07 11:42:10', '2025-05-07 11:42:23'),
(8, 1, 15, NULL, 2, '2025-05-07 12:10:31', '2025-05-08 18:39:15'),
(17, 10, 15, 'M', 142, '2025-05-26 19:06:26', '2025-05-26 19:38:27');



CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `proses` varchar(100) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `kategori` varchar(50) DEFAULT NULL,
  `jenis_lengan` varchar(50) DEFAULT NULL,
  `terjual` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `produk` (`id`, `gambar`, `nama_produk`, `harga`, `material`, `proses`, `sku`, `tags`, `stok`, `kategori`, `jenis_lengan`, `terjual`, `deskripsi`) VALUES
(13, '68138b8e8dc48.png', 'Batik Surabaya', 1000000.00, 'dsds', 'dsdsd', 'dsdsds', 'dsdsds', 435, 'pria', 'panjang', '', NULL),
(14, '6813982d08455.png', 'Batik Lampung', 2311111.00, 'dsds', 'Press', 'SAFW', 'dsdsds', 22, 'anak_anak', 'pendek', '', NULL),
(15, '681b35efa9ae1.png', 'Batik Bengkulu', 400000.00, 'karbon', 'press', 'DDSD', 'FSDAD', 56, 'wanita', 'pendek', '', NULL),
(16, '6813981d7f527.png', 'Batik Betawi', 900000.00, 'Kain', 'dsdsd', 'dsdsds', 'FSDAD', 37, 'wanita', 'pendek', '', NULL),
(17, 'sss.jpg.png ', 'sasa', 13212.00, 'sasa', 'sasa', 'sasa', '12', 12, 'pria', 'panjang', NULL, NULL),
(18, 'sss.jpg.png ', 'sasa', 12121.00, 'sasasa', 'sasa', 'sas', 'asasa', 12, 'pria', 'panjang', NULL, NULL),
(19, '68138ba7d234c.png', 'sasa', 121.00, 'sasa', 'sasa', 'sasa', 'sasa', 31, 'wanita', 'pendek', NULL, NULL),
(20, '6810983d12392.png', 'sasasa', 121.00, 'sasasa', 'sas', 'asas', 'asas1', 212, 'pria', 'pendek', NULL, NULL),
(21, '68127284e11bd.png', 'Batik Surabayas', 21.00, 'sasas', 'sa', 'sa', 's', 21, 'pria', 'panjang', '', NULL),
(23, '681274500e1b9.png', '212', 21212.00, '21', '2121', '21212', '121', 2122, 'pria', 'panjang', NULL, NULL),
(24, '681274a3701cf.png', '21212', 12121.00, '12', '21', '212', '121', 21, 'pria', 'panjang', NULL, NULL),
(25, '681274bbbea33.png', 'sasa', 2121.00, '212', '12121', '221', '212', 121, 'pria', 'panjang', NULL, NULL),
(26, '68128404d5962.png', '12121', 2121.00, '21212', '1212', '121', '2121', 212121, 'pria', 'panjang', NULL, NULL),
(27, '68138b6beb6d5.png', 'asas', 1212.00, 'sasas', 'asas', 'asas', 'asasas', 12, 'wanita', 'pendek', NULL, NULL),
(28, NULL, 'Cbr Sempak', 20000000.00, 'besi', 'las', 'sasa', 'sasa', 100, 'wanita', 'pendek', NULL, 'ggwp '),
(29, '681b358ca1a22.png', 'Radit', 99999999.99, 'sasas', '2121', 'sasa', 'FSDAD', 1, 'pria', 'pendek', NULL, 'y '),
(30, '681b44b1aebd1.png', 'Batik Lampung', 900000.00, 'Kain', 'Press', 'sasa', 'FSDAD', 9, 'wanita', 'pendek', NULL, 'Keren '),
(31, '681b6b4cca011.jpg', 'Batik Keren', 400000.00, 'Kain', 'Press', 'DADA', 'FSDAD', 99, 'pria', 'panjang', NULL, 'Batik Keren langan panjang ');


CREATE TABLE `status_log` (
  `id` int(11) NOT NULL,
  `checkout_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `status_log` (`id`, `checkout_id`, `status_id`, `waktu`) VALUES
(1, 2, 1, '2025-05-28 09:31:29'),
(2, 3, 1, '2025-05-28 09:32:24');

CREATE TABLE `status_transaksi` (
  `id` int(11) NOT NULL,
  `nama_status` varchar(20) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `status_transaksi` (`id`, `nama_status`, `keterangan`) VALUES
(1, 'Menunggu Konfirmasi', NULL),
(2, 'Diproses', NULL),
(3, 'Dikirim', NULL),
(4, 'Selesai', NULL);

-- --------------------------------------------------------


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `secret_question` text NOT NULL,
  `secret_answer` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `users` (`id`, `username`, `email`, `nomor_hp`, `tanggal_lahir`, `jenis_kelamin`, `foto`, `role`, `password`, `nama_lengkap`, `secret_question`, `secret_answer`, `created_at`) VALUES
(1, 'abuy', 'abay@gmail.com', '807775580899', '2004-04-10', 'L', 'foto_681b4af80538f.png', NULL, '$2y$10$AnuQsjz/veb31REsmX.cmeMbptcvVX9y7X1n.Juqcl6WN4qoPgLHG', 'Muhammad Abyaz Zaydan', 'makanan', 'rendang', '2025-05-01 03:44:17'),
(2, 'aabb', 'abb@gmail.com', '087775580899', '2005-04-10', 'L', '', NULL, '$2y$10$ZuqXIa7RmSN9eawCmsPyHe9kSbVDh8NP6dN6bTz6bi39oQIkuBXZ.', NULL, 'makanan', 'abb', '2025-05-01 22:15:06'),
(4, 'bduy', 'bduy@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$10$6Iq5IcLnuerugr5oJ85Lb.7OfGNvmivRYaaY0cQpQ/PuD5P2Grwo6', NULL, 'makanan', 'sate kulit', '2025-05-02 01:24:31'),
(5, 'ros', 'ros@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$10$MgFYQVoSCyDCDlbRJl8kBeHJA3lvou6J7g4x8JuJN1eKQbgyFopeu', NULL, 'makanan', 'rendang', '2025-05-07 03:52:04'),
(6, 'Bdil', 'bdil@gmail.com', '9090909', '1999-02-13', 'L', 'foto_681b54b4d05c9.png', NULL, '$2y$10$Xoko5KnRi1/6qyjah9LrHeXXJpYvHnudnJdugZV9InItLf3TJi64m', 'Fadhil Star', 'hobi', 'motoran', '2025-05-07 19:38:11'),
(7, 'salman', 'salman@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$10$KB/2MRauz3yz2fVm3jYVYOb2lR9PZg9FHasi3bjSwKdTfMZrlfAz.', NULL, 'makanan', 'mangga', '2025-05-07 19:42:35'),
(8, 'jek', 'jek@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$10$8zldHH1.6sni5YaqpySDZOvkuGthuKJVgp6z4M67d7mXwdZ/BmRZ.', NULL, 'makanan', 'rendang', '2025-05-07 19:45:52'),
(9, 'admin123', 'admin@example.com', '081234567890', '1990-01-01', 'L', NULL, 'admin', '$2y$10$eW5BNi1NaXBxR3dzN0NBeOJz7jK5TLUCUcfFIK2aJYO91LntT20yW', 'Administrator', 'Apa nama hewan peliharaan pertamamu?', 'Kucing', '2025-05-07 14:51:50'),
(10, 'aaa', 'aaa@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$10$ScX0/aGSoFJ3tOM1vl123O4BxgrQhHZnWqtw4ewo537T140E.a.Bu', NULL, 'makanan', 'rendang', '2025-05-24 03:47:38');


ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);


ALTER TABLE `checkout_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checkout_id` (`checkout_id`),
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `favorit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_favorit` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `status_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checkout_id` (`checkout_id`),
  ADD KEY `status_id` (`status_id`);


ALTER TABLE `status_transaksi`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `checkout_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `favorit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;


ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;


ALTER TABLE `status_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `status_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_transaksi` (`id`);


ALTER TABLE `checkout_items`
  ADD CONSTRAINT `checkout_items_ibfk_1` FOREIGN KEY (`checkout_id`) REFERENCES `checkout` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkout_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`);

ALTER TABLE `favorit`
  ADD CONSTRAINT `favorit_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorit_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;


ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`);


ALTER TABLE `status_log`
  ADD CONSTRAINT `status_log_ibfk_1` FOREIGN KEY (`checkout_id`) REFERENCES `checkout` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `status_log_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_transaksi` (`id`);
COMMIT;
