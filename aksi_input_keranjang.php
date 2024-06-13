<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the request method is POST and required data is present
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['book_id']) && !empty($_POST['judul_buku']) && !empty($_POST['jumlah'])) {
    $book_id = intval($_POST['book_id']);
    $judul_buku = $koneksi->real_escape_string($_POST['judul_buku']);
    $jumlah = intval($_POST['jumlah']);
    $username = $_SESSION['username'];

    // Retrieve user_id from the session or users table
    $sql = "SELECT id_user FROM user WHERE username = '" . $koneksi->real_escape_string($username) . "'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = intval($user['id_user']);

        // Check if the book already exists in the cart
        $check_sql = "SELECT id_keranjang FROM keranjang WHERE id_user = $user_id AND id_buku = $book_id";
        $check_result = $koneksi->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Book already exists in the cart, so update the quantity
            $update_sql = "UPDATE keranjang SET jumlah = jumlah + $jumlah WHERE id_user = $user_id AND id_buku = $book_id";
            if ($koneksi->query($update_sql) === TRUE) {
                header("Location: keranjang_page.php"); // Redirect to the cart page
                exit();
            } else {
                echo "Error updating record: " . $koneksi->error;
            }
        } else {
            // Book does not exist in the cart, so insert a new record
            $insert_sql = "INSERT INTO keranjang (id_user, id_buku, judul_buku, jumlah) VALUES ($user_id, $book_id, '$judul_buku', $jumlah)";
            if ($koneksi->query($insert_sql) === TRUE) {
                header("Location: keranjang_page.php"); // Redirect to the cart page
                exit();
            } else {
                echo "Error inserting record: " . $koneksi->error;
            }
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request. Please ensure all required data is provided.";
}
