<?php
// Include your database connection
session_start();
include 'proses/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdf = $_POST['pdf'];
    $invoice_id = $_POST['invoice_id'];

    // Get the current download count and allowed quantity
    $query = "SELECT jumlah, downloads FROM invoice WHERE id_pembelian = '$invoice_id'";
    $result = $koneksi->query($query);
    $row = $result->fetch_assoc();

    if ($row['downloads'] < $row['jumlah']) {
        // Increment the download count
        $new_count = $row['downloads'] + 1;
        $update_query = "UPDATE invoice SET downloads = '$new_count' WHERE id_pembelian = '$invoice_id'";
        $koneksi->query($update_query);

        // Redirect to the PDF file
        header("Location: $pdf");
        exit;
    } else {
        echo "Download Mencapai Batas.";
    }
} else {
    echo "Invalid request.";
}
?>
