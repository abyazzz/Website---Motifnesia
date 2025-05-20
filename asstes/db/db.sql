
CREATE DATABASE Motifnesia;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `favorit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `favorit` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 1, 13, '2025-05-06 21:22:45'),
(3, 1, 14, '2025-05-07 11:42:35');


CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `keranjang` (`id`, `user_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
(3, 1, 16, 3, '2025-05-06 19:46:44', '2025-05-07 11:42:18'),
(4, 1, 13, 5, '2025-05-06 20:42:47', '2025-05-07 11:42:20'),
(5, 5, 13, 2, '2025-05-06 20:52:16', '2025-05-06 20:52:18'),
(6, 5, 14, 3, '2025-05-06 20:52:22', '2025-05-06 20:52:24'),
(7, 1, 14, 3, '2025-05-07 11:42:10', '2025-05-07 11:42:23');


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


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `favorit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `favorit`
  ADD CONSTRAINT `favorit_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorit_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;


ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`);
COMMIT;

