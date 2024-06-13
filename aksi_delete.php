<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['book_id'])) {
        $book_id = $_POST['book_id'];
        
        // Hapus data buku dari database
        $sql = "DELETE FROM buku WHERE id_buku = '$book_id'";
        
        if ($koneksi->query($sql) === TRUE) {
            // Redirect ke halaman sebelumnya atau ke halaman tertentu jika perlu
            header("Location: home_page.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else {
        echo "No book ID provided.";
    }
} else {
    echo "Invalid request method.";
}
?>
