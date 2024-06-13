<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Book Data</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   
</head>

<body class="top-navigation">
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom white-bg">
                <nav class="navbar navbar-static-top" role="navigation">
                    <div class="navbar-header">
                        <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                            <i class="fa fa-reorder"></i>
                        </button>
                        <a href="#" class="navbar-brand">MI Book Store</a>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar">
                        <ul class="nav navbar-nav"></ul>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <a href="login.php">
                                    <i class="fa fa-sign-out"></i> Log out
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="container">
                <h1 class="my-4">Upload Book Data</h1>
                <form action="aksi_upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image_file">Upload Image:</label>
                        <input type="file" id="image_file" name="image_file" accept="image/jpeg" required onchange="previewImage(this);">
                    </div>
                    <div class="form-group">
                        <img id="preview" src="#" alt="Book Cover Preview" style="max-width: 100%; height: auto; display: none;">
                    </div>
                    <div class="form-group">
                        <label for="judul_buku">Judul Buku:</label>
                        <input type="text" class="form-control" id="judul_buku" name="judul_buku" required>
                    </div>
                    <div class="form-group">
                        <label for="id_kategori">Kategori:</label>
                        <select class="form-control" id="id_kategori" name="id_kategori" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                            <?php
                            $sql = "SELECT id_kategori, kategori FROM kategori";
                            $result = $koneksi->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id_kategori'] . "'>" . $row['kategori'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="harga">Price:</label>
                        <input type="number" class="form-control" id="harga" name="harga" required >
                    </div>
                    
                    <div class="form-group">
                        <label for="sinopsis">Description:</label>
                        <textarea class="form-control" id="sinopsis" name="sinopsis" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="id_penulis">Penulis:</label>
                        <select class="select2_demo_3 form-control" id="id_penulis" name="id_penulis" required>
                        <option value="" disabled selected>Pilih Penulis</option>
                            <?php
                            $sql = "SELECT id_penulis, nama_penulis FROM penulis";
                            $result = $koneksi->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id_penulis'] . "'>" . $row['nama_penulis'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_penerbit">Penerbit:</label>
                        <select class="form-control" id="id_penerbit" name="id_penerbit" required>
                            <option value="" disabled selected>Pilih Penerbit</option> <!-- Placeholder -->
                            <?php
                            $sql = "SELECT id_penerbit, nama_penerbit FROM penerbit";
                            $result = $koneksi->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id_penerbit'] . "'>" . $row['nama_penerbit'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_supplier">Supplier:</label>
                        <select class="form-control" id="id_supplier" name="id_supplier" required>
                        <option value="" disabled selected>Pilih Supplier</option>
                            <?php
                            $sql = "SELECT id_supplier, nama FROM supplier";
                            $result = $koneksi->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id_supplier'] . "'>" . $row['nama'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pdf_file">Upload PDF:</label>
                        <input type="file" class="form-control-file" id="pdf_file" name="pdf_file" accept=".pdf" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview').style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>