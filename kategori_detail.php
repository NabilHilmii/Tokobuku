<?php
session_start();
include 'proses/connection.php';

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil parameter kategori dari URL
$kategoriDipilih = '';
if (!empty($_GET['kategori'])) {
    $kategoriDipilih = $_GET['kategori'];
}

// Query untuk mengambil barang berdasarkan kategori
$queryBarang = "SELECT buku.id_buku, buku.judul_buku, buku.harga, buku.gambar, kategori.kategori, penulis.nama_penulis, penerbit.nama_penerbit 
                FROM buku 
                JOIN kategori ON buku.id_kategori = kategori.id_kategori
                JOIN penulis ON buku.id_penulis = penulis.id_penulis 
                JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
               
                WHERE kategori.kategori = '$kategoriDipilih'";
$resultBarang = $koneksi->query($queryBarang);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store Home Page</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
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
            <div class="wrapper">

                <h3>Barang dalam Kategori: <?php echo ($kategoriDipilih); ?></h3>
                <div class="row">
                    <?php while ($rowKategori = $resultBarang->fetch_assoc()) { ?>
                        <div class="col-md-3">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                    <?php $imagePath = $rowKategori['gambar']; ?>

                                    <div class="product-imitation">
                                        <img src="<?php echo $imagePath ?>" alt="<?php echo $rowKategori['judul_buku'] ?>" style="width:100%; height:600px; object-fit:cover;">
                                    </div>
                                    <div class="product-desc">
                                        <span class="product-price"><?php echo $rowKategori["harga"] ?></span>
                                        <small class="text-muted"><?php echo $rowKategori["kategori"] ?></small>
                                        <a href="#" class="product-name"><?php echo $rowKategori["judul_buku"] ?></a>
                                        <div class="small m-t-xs">
                                            <strong>Penulis: </strong><?php echo $rowKategori["nama_penulis"] ?><br>
                                        </div>
                                        <form action="detail_product_page.php" method="POST" class="text-center">
                                            <input type="hidden" name="book_id" value="<?php echo $rowKategori['id_buku']?>">
                                            <button type="submit" class="btn btn-primary btn-md">Buy Now</button>
                                        </form>




                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
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
        </div>
    </div>

    <?php
    // Tutup koneksi
    $koneksi->close();
    ?>
    <!-- Bootstrap JS (Opsional) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green",
            });
        });
    </script>
</body>

</html>