<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if(isset($_POST['judul_buku']) && isset($_POST['id_kategori']) && isset($_POST['harga']) && isset($_POST['sinopsis']) && isset($_POST['id_penulis']) && isset($_POST['id_penerbit']) && isset($_POST['id_supplier']) && isset($_FILES['image_file']) && isset($_FILES['pdf_file'])) {
    // Folder tempat file diunggah
    $uploadDir = 'uploads/';

    // Folder tempat file PDF disimpan
    $pdfFolder = $uploadDir . 'pdf/';

    // Folder tempat file gambar disimpan
    $imageFolder = $uploadDir . 'image/';

    // Informasi file gambar
    $imageFileName = $_FILES['image_file']['name'];
    $imageTmpName = $_FILES['image_file']['tmp_name'];
    $imageSize = $_FILES['image_file']['size'];
    $imageError = $_FILES['image_file']['error'];

    // Informasi file PDF
    $pdfFileName = $_FILES['pdf_file']['name'];
    $pdfTmpName = $_FILES['pdf_file']['tmp_name'];
    $pdfSize = $_FILES['pdf_file']['size'];
    $pdfError = $_FILES['pdf_file']['error'];

    // Memeriksa apakah tidak ada error saat mengunggah file gambar dan ukuran file PDF tidak melebihi 2MB
    if($imageError === 0 && $pdfError === 0) {
        // Batasan ukuran file PDF 2MB (2 * 1024 * 1024 bytes)
        $maxPdfSize = 2000000;

        if ($pdfSize <= $maxPdfSize) {
            $newImageName = $imageFileName;
            $imageUploadPath = $imageFolder . $newImageName;

            $newPdfName = $pdfFileName;
            $pdfUploadPath = $pdfFolder . $newPdfName;

            // Memindahkan file yang diunggah ke folder tujuan
            if(move_uploaded_file($imageTmpName, $imageUploadPath) && move_uploaded_file($pdfTmpName, $pdfUploadPath)) {
                // Mendapatkan data dari form
                $judul_buku = $_POST['judul_buku'];
                $id_kategori = $_POST['id_kategori'];
                $harga = $_POST['harga'];
                $sinopsis = $_POST['sinopsis'];
                $id_penulis = $_POST['id_penulis'];
                $id_penerbit = $_POST['id_penerbit'];
                $id_supplier = $_POST['id_supplier'];

                // Menyimpan informasi buku ke dalam database
                $sql = "INSERT INTO buku (judul_buku, gambar, sinopsis, pdf, harga, id_penulis, id_penerbit, id_supplier, id_kategori) VALUES ('$judul_buku', '$imageUploadPath', '$sinopsis', '$pdfUploadPath', '$harga', '$id_penulis', '$id_penerbit', '$id_supplier', '$id_kategori')";

                if ($koneksi->query($sql) === TRUE) {
                    header('location: home_page.php');
                    echo "<script>alert('File Berhasil di Upload');history.go(-1);</script>";
                } else {
                    echo "<script>alert('File Gagal Terupload');history.go(-1);</script>";
                }
            } else {
                echo "<script>alert('Terjadi kesalahan saat mengunggah file.');history.go(-1);</script>";
            }
        } else {
            echo "<script>alert('Ukuran file PDF melebihi 2MB.');history.go(-1);</script>";
        }
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengunggah file.');history.go(-1);</script>";
    }
} else {
    echo "<script>alert('Field yang diperlukan tidak lengkap.');history.go(-1);</script>";
}
?>
