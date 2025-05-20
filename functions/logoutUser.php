<?php
session_start();        // Mulai session (biar bisa dihapus)
session_unset();        // Hapus semua variabel dalam session
session_destroy();      // Hancurkan session

header("Location: ../index.php");  // Arahkan ke halaman login
exit;