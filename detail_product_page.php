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
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | E-commerce product detail</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="css/plugins/slick/slick.css" rel="stylesheet">
    <link href="css/plugins/slick/slick-theme.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">



</head>

<body>
    <div id="wrapper">
        <?php include 'user_navbar.php'; ?>
        <div id="page-wrapper" class="gray-bg">

            <div class="row border-bottom">
                <?php include 'top_navbar.php'; ?>

            </div>

            <div class="row">
                <div class="col-lg-12">

                    <div class="ibox product-detail">
                        <div class="ibox-content">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="product-images ">
                                        <img src="<?= $book['gambar'] ?>" alt="<?= $book['judul_buku'] ?>" style="width: auto; height: 600px;">

                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h2 class="font-bold m-b-xs">
                                        <?= $book['judul_buku'] ?>
                                    </h2>

                                    <hr>
                                    <div>
                                        <a data-toggle="modal" class="btn btn-primary pull-right" href="#modal-keranjang-form">Tambahkan Ke Keranjang</a>
                                        <div id="modal-keranjang-form" class="modal fade" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="text-center">
                                                                <h3 class="m-t-none m-b">Tambahkan ke Keranjang</h3>
                                                                <form role="form" action="aksi_input_keranjang.php" method="post">
                                                                    <div class="form-group">
                                                                        <img src="<?= $book['gambar'] ?>" alt="<?= $book['judul_buku'] ?>" style="width:50px; height:50px; object-fit:cover; margin: 10px;">
                                                                        <h2 class="font-bold m-b-xs">
                                                                            <?= $book['judul_buku'] ?>
                                                                        </h2>
                                                                        <input type="number" class="touchspin1" name="jumlah" value="1" min="1" required>
                                                                        <input type="hidden" name="book_id" value="<?= $book['id_buku'] ?>">
                                                                        <input type="hidden" name="judul_buku" value="<?= $book['judul_buku'] ?>">
                                                                    </div>
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h1 class="product-main-price"><?= $book['harga'] ?></h1>
                                    </div>
                                    <hr>
                                    <h4>Sinopsis</h4>

                                    <div class="large text-muted">
                                        <?= $book['sinopsis'] ?>
                                        <br />

                                    </div>
                                    <dl class="m-t-xl">
                                        <dt>Penulis</dt>
                                        <dd><?= $book['nama_penulis'] ?></dd>
                                        <dt>Penerbit</dt>
                                        <dd><?= $book['nama_penerbit'] ?></dd>


                                    </dl>
                                    <div>
                                        <a data-toggle="modal" class="btn btn-primary pull-right" href="#modal-beli-form">Beli</a>
                                        <div id="modal-beli-form" class="modal fade" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="text-center">
                                                                <h3 class="m-t-none m-b">Beli Buku</h3>
                                                                <form role="form" action="aksi_beli.php" method="post">
                                                                    <div class="form-group">
                                                                        <img src="<?= $book['gambar'] ?>" alt="<?= $book['judul_buku'] ?>" style="width:100px; height:100px; object-fit:cover; margin: 10px;">
                                                                        <h2 class="font-bold m-b-xs">
                                                                            <?= $book['judul_buku'] ?>
                                                                        </h2>
                                                                        <input type="number" class="touchspin1" name="jumlah" value="1" min="1" required>
                                                                        <input type="hidden" name="book_id" value="<?= $book['id_buku'] ?>">
                                                                        <input type="hidden" name="judul_buku" value="<?= $book['judul_buku'] ?>">
                                                                    </div>
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-primary">Beli</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox product-detail">
                            <div class="ibox-content">


                                <div class="col-xl-4 mb">

                                    <?php
                                    // Ambil data ulasan buku dari database
                                    $sql = "SELECT user.username, ulasan.komentar,user.foto FROM ulasan
                                        JOIN user ON user.id_user = ulasan.id_user
                                        WHERE id_buku = $book_id";
                                    $result = $koneksi->query($sql);

                                    // Periksa apakah ada ulasan tersedia
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <div class="profile-container" style="display: flex;align-items: center;">
                                                <div class="product-image" style="margin-right: 10px;">
                                                    <img alt="image" class="img" src="<?php echo $row['foto']; ?>" style="width: 50px; height: 50px; border-radius: 50%;">
                                                </div>
                                                <div class="username">
                                                    <h5 class="mt-1"><strong><?php echo $row['username']; ?></strong></h5>
                                                </div>
                                            </div>
                                            <p><strong>Komentar:</strong> <?php echo $row['komentar']; ?></p>
                                    <?php
                                        }
                                    } else {
                                        echo "Belum ada ulasan untuk buku ini.";
                                    }
                                    ?>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
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



    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/t