<?php
session_start();
include 'proses/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pembelian = $_POST['id_pembelian'];

    // Update status pembayaran menjadi "Dibayar"
    $query_update_pembayaran = "UPDATE pembayaran 
                                JOIN invoice ON pembayaran.id_detail = invoice.id_detail 
                                SET pembayaran.status = 'Dibayar' 
                                WHERE invoice.id_pembelian = '$id_pembelian'";
    $koneksi->query($query_update_pembayaran);

    

    // Redirect kembali ke halaman detail
    header("Location: order_page.php");
    exit();
}
?>
