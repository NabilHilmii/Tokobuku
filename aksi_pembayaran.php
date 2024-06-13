<?php
session_start();
include 'proses/connection.php';

// Ensure a session has started
if (!isset($_SESSION['username'])) {
    // Redirect to login page if no session has started
    header("Location: login.php");
    exit;
}

// Check if id_pembelian is present in POST data
if (!isset($_POST['id_pembelian']) || empty($_POST['id_pembelian'])) {
    // If id_pembelian is not present, display an error message or redirect
    echo "ID Pembelian tidak ditemukan.";
    exit;
}

// Get id_pembelian from POST data
$id_pembelian = $_POST['id_pembelian'];

// Get username from session
$username = $_SESSION['username'];
$status = "Belum Bayar"; // Set default status to "Belum Bayar"

// Sanitize inputs to prevent SQL injection
$id_pembelian = $koneksi->real_escape_string($id_pembelian);
$username = $koneksi->real_escape_string($username);
$status = $koneksi->real_escape_string($status);

// Create and run the query
$sql = "INSERT INTO pembayaran (id_pembelian, username, status) VALUES ('$id_pembelian', '$username', '$status')";
if ($koneksi->query($sql) === TRUE) {
    // Redirect to success page if data insertion is successful
    header("Location: invoice_page.php");
    exit;
} else {
    // If there is an error, display the error message
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}

// Close the connection
$koneksi->close();
?>
