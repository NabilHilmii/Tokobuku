<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_ids = $_POST['cart_ids'] ?? [];

    if (!empty($cart_ids)) {
        // Prepare the SQL DELETE statement with placeholders
        $placeholders = str_repeat('?,', count($cart_ids) - 1) . '?';
        $sql = "DELETE FROM keranjang WHERE id_keranjang IN ($placeholders)";
        
        // Prepare the statement
        $stmt = $koneksi->prepare($sql);
        
        // Check if statement preparation was successful
        if ($stmt === false) {
            $_SESSION['message'] = "Error preparing statement: " . $koneksi->error;
        } else {
            // Dynamically create an array for binding parameters
            $typeStr = str_repeat('i', count($cart_ids));
            $stmt->bind_param($typeStr, ...$cart_ids);
            
            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION['message'] = "Selected items removed from cart.";
            } else {
                $_SESSION['message'] = "Error removing items: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    } else {
        $_SESSION['message'] = "No items selected for removal.";
    }
}

header("Location: keranjang_page.php");
exit();
?>
