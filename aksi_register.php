<?php
include "proses/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'user';

    // Tangkap data foto
    if(isset($_FILES["image"])) {
        $targetDir = "images/"; // Lokasi penyimpanan foto
        $targetFile = $targetDir . basename($_FILES["image"]["name"]); // Path lengkap foto
        $uploadOk = 1; // Flag untuk menandakan apakah upload berhasil atau tidak
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // Ekstensi file gambar

        // Cek apakah file gambar benar-benar gambar atau bukan
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            // Jika benar gambar, lanjutkan proses upload
            $uploadOk = 1;
        } else {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }

        // Cek apakah file sudah ada di server
        if (file_exists($targetFile)) {
            echo "Maaf, file tersebut sudah ada.";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Maaf, ukuran file terlalu besar.";
            $uploadOk = 0;
        }

        // Hanya izinkan beberapa format file gambar
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Maaf, hanya format JPG, JPEG, PNG, & GIF yang diperbolehkan.";
            $uploadOk = 0;
        }

        // Cek jika $uploadOk tidak berubah menjadi 0 karena error
        if ($uploadOk == 0) {
            echo "Maaf, file Anda tidak diunggah.";
        // Jika semuanya berjalan lancar, coba upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Jika berhasil diunggah, masukkan data ke database
                $sql = "INSERT INTO user (username, foto, email, password, role) VALUES (?, ?, ?, ?, ?)";
                $stmt = $koneksi->prepare($sql);
                $stmt->bind_param("sssss", $username, $targetFile, $email, $password, $role);
                if ($stmt->execute()) {
                    header('Location: login.php'); // Redirect ke halaman login jika registrasi berhasil
                    exit();
                } else {
                    echo "Terjadi kesalahan saat memasukkan data ke database.";
                }
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        }
    } else {
        echo "Foto tidak ditemukan.";
    }
}
?>
