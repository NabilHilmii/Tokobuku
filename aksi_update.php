<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$book_id = $_POST['book_id'];
$book_name = $_POST['book_name'];
$price = $_POST['price'];
$sinopsis = $_POST['Sinopsis'];
$id_kategori = $_POST['id_kategori'];
$id_penulis = $_POST['id_penulis'];
$id_penerbit = $_POST['id_penerbit'];

$image_updated = false;
$image_path = '';

if (!empty($_FILES['book_image']['name'])) {
    $target_dir = "uploads/image/";
    $target_file = $target_dir . basename($_FILES["book_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["book_image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["book_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
            $image_updated = true;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        echo "File is not an image.";
        exit();
    }
}

if ($image_updated) {
    $sql = "UPDATE buku SET judul_buku=?, harga=?, sinopsis=?, id_kategori=?, id_penulis=?, id_penerbit=?, gambar=? WHERE id_buku=?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sdsiiisi", $book_name, $price, $sinopsis, $id_kategori, $id_penulis, $id_penerbit, $image_path, $book_id);
} else {
    $sql = "UPDATE buku SET judul_buku=?, harga=?, sinopsis=?, id_kategori=?, id_penulis=?, id_penerbit=? WHERE id_buku=?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sdsiiii", $book_name, $price, $sinopsis, $id_kategori, $id_penulis, $id_penerbit, $book_id);
}

if ($stmt->execute()) {
    header("Location: home_page.php");
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$koneksi->close();
?>
