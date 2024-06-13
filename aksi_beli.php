<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username'];
    $book_id = $_POST['book_id'];
    $judul_buku = $_POST['judul_buku'];
    $jumlah = $_POST['jumlah'];

    // Mendapatkan id_user
    $sql = "SELECT id_user FROM user WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_id = intval($user['id_user']);

    // Mendapatkan harga buku
    $sql = "SELECT harga FROM buku WHERE id_buku = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();
    $harga = $buku['harga'];

    // Insert ke tabel pembelian
    $tanggal_pembelian = date('Y-m-d');
    $insert_pembelian_sql = "INSERT INTO pembelian (id_user, username, tanggal) VALUES (?, ?, ?)";
    $stmt = $koneksi->prepare($insert_pembelian_sql);
    $stmt->bind_param("iss", $user_id, $username, $tanggal_pembelian);
    if ($stmt->execute()) {
        $id_pembelian = $koneksi->insert_id;

        // Insert ke tabel invoice
        $insert_invoice_sql = "INSERT INTO invoice (id_pembelian, id_buku, judul_buku, harga, jumlah) VALUES (?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($insert_invoice_sql);
        $stmt->bind_param("iisdi", $id_pembelian, $book_id, $judul_buku, $harga, $jumlah);
        if ($stmt->execute()) {
            // Insert ke tabel pembayaran dengan status "Belum Dibayar"
            $insert_pembayaran_sql = "INSERT INTO pembayaran (id_detail, status) VALUES (?, 'Belum Dibayar')";
            $id_detail = $koneksi->insert_id;
            $stmt = $koneksi->prepare($insert_pembayaran_sql);
            $stmt->bind_param("i", $id_detail);
            if ($stmt->execute()) {
                header("Location: order_page.php");
                exit();
            } else {
                echo "Error inserting record into pembayaran: " . $stmt->error;
            }
        } else {
            echo "Error inserting record into invoice: " . $stmt->error;
        }
    } else {
        echo "Error inserting record into pembelian: " . $stmt->error;
    }
}
?>
