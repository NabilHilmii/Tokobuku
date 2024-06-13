<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil id_user dari tabel users berdasarkan username
$sql_user = "SELECT id_user FROM user WHERE username = '$username'";
$result_user = $koneksi->query($sql_user);

if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();
    $id_user = $user_data['id_user'];
} else {
    echo "User not found.";
    exit();
}

$id_buku = $_POST['id_buku'];
$komentar = $_POST['komentar'];

// Masukkan data ulasan ke dalam tabel ulasan
$sql = "INSERT INTO ulasan(id_user, id_buku, komentar) VALUES ('$id_user', '$id_buku', '$komentar')";
$query = $koneksi->query($sql);

if ($query === true) {
    header('location: ulasan_page.php');
} else {
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}
?>
