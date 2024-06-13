<?php
session_start();
include 'proses/connection.php';

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

            <div class="wrapper wrapper-content">
                <?php
                if ($koneksi->connect_error) {
                    die("Koneksi gagal: " . $koneksi->connect_error);
                }

                // Ambil parameter kategori dari URL jika ada
                $kategoriDipilih = '';
                if (!empty($_GET['kategori'])) {
                    $kategoriDipilih = $_GET['kategori'];
                }

                // Query untuk mengambil semua kategori
                $queryKategori = "SELECT DISTINCT kategori, gambar FROM kategori";
                $resultKategori = $koneksi->query($queryKategori);
                ?>
                <div class="container">
                   
                    <div class="row">
                        <?php while ($rowKategori = $resultKategori->fetch_assoc()) { ?>
                            <div class="col-xl-4 mb-1">
                                <div class="ibox">
                                    <!-- Mengubah div menjadi a -->
                                    <a class="ibox-content product-box" href="kategori_detail.php?kategori=<?php echo ($rowKategori['kategori']); ?>" style="display: flex; align-items: center;">
                                        <!-- Menampilkan gambar dari database -->
                                        <img src="<?php echo $rowKategori['gambar']; ?>" alt="Gambar Produk" style="width:100px; height:100px; object-fit:cover; margin: 10px;">
                                        <!-- Menampilkan kategori dari database -->
                                        <div class="product-text">
                                            <?php echo $rowKategori['kategori']; ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                        <?php } ?>
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