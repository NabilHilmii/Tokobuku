<?php
// Proses untuk memperbarui jumlah dalam keranjang
// Proses untuk memperbarui jumlah dalam keranjang

session_start();
include 'proses/connection.php';

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Pastikan ada data yang dikirim dari form
$cart_id = $_POST['cart_id'] ?? null;
$book_id = $_POST['book_id'] ?? null;
$action = $_POST['action'] ?? null;

if ($action === 'plus') {
    // Perbarui jumlah dalam database sesuai dengan tindakan yang diambil
    $sql = "UPDATE keranjang SET jumlah = jumlah + 1 WHERE id_keranjang = $cart_id";

} elseif ($action === 'minus') {
    // Perbarui jumlah dalam database sesuai dengan tindakan yang diambil
    $sql = "UPDATE keranjang SET jumlah = jumlah - 1 WHERE id_keranjang = $cart_id";
}

if ($koneksi->query($sql) === TRUE) {
    // Redirect kembali ke halaman keranjang setelah berhasil memperbarui
    header("Location: keranjang_page.php");
    exit();
} else {
    // Jika ada kesalahan saat memperbarui, tampilkan pesan kesalahan
    echo "Error updating record: " . $koneksi->error;
}

?>
