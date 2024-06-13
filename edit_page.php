<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$book_id = $_POST['book_id'];
$sql = "SELECT buku.id_buku, buku.judul_buku, buku.harga, buku.gambar, buku.sinopsis, kategori.kategori, penulis.nama_penulis, penerbit.nama_penerbit 
        FROM buku 
        JOIN kategori ON buku.id_kategori = kategori.id_kategori
        JOIN penulis ON buku.id_penulis = penulis.id_penulis 
        JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
        WHERE buku.id_buku = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
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
                <h1 class="my-4">Edit Book</h1>
                <form action="aksi_update.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="book_id" value="<?= $book['id_buku'] ?>">
                    <div class="form-group">
                        <label for="book-image">Image:</label>
                        <input type="file" class="form-control-file" id="book-image" name="book_image" value="<?= $book['gambar'] ?>">
                        
                        <img src="<?= $book['gambar'] ?>" alt="<?= $book['judul_buku'] ?>" style="width: auto; height: 150px;" >
                    </div>
                    <div class="form-group">
                        <label for="book-name">Name:</label>
                        <input type="text" class="form-control" id="book-name" name="book_name" value="<?= $book['judul_buku'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="book-price">Price:</label>
                        <input type="text" class="form-control" id="book-price" name="price" value="<?= $book['harga'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="book-sinopsis">Description:</label>
                        <textarea class="form-control" id="book-sinopsis" name="Sinopsis"><?= $book['sinopsis'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="book-category">Category:</label>
                        <select class="form-control" id="id_kategori" name="id_kategori" required>
                            <?php
                            $sql = "SELECT id_kategori, kategori FROM kategori";
                            $result = $koneksi->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $selected = ($row['id_kategori'] == $book['id_kategori']) ? 'selected' : '';
                                    echo "<option value='" . $row['id_kategori'] . "' $selected>" . $row['kategori'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="book-penulis">Penulis:</label>
                        <select class="form-control" id="id_penulis" name="id_penulis" required>
                            <?php
                            $sql = "SELECT id_penulis, nama_penulis FROM penulis";
                            $result = $koneksi->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $selected = ($row['id_penulis'] == $book['id_penulis']) ? 'selected' : '';
                                    echo "<option value='" . $row['id_penulis'] . "' $selected>" . $row['nama_penulis'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="book-penerbit">Penerbit:</label>
                        <select class="form-control" id="id_penerbit" name="id_penerbit" required>
                            <?php
                            $sql = "SELECT id_penerbit, nama_penerbit FROM penerbit";
                            $result = $koneksi->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $selected = ($row['id_penerbit'] == $book['id_penerbit']) ? 'selected' : '';
                                    echo "<option value='" . $row['id_penerbit'] . "' $selected>" . $row['nama_penerbit'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="footer">
                <div class="pull-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Example Company &copy; 2014-2017
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
