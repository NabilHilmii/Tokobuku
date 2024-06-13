<?php
session_start();
include 'proses/connection.php';
// Mengganti include dengan require
$_SESSION['email'];
   
$role = $_SESSION['role'];
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
        <?php
        if ($role == 'admin') {
            include 'admin_navbar.php'; // Navbar untuk admin
        } else {
            include 'user_navbar.php'; // Navbar untuk user biasa
        }
        ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <?php include 'top_navbar.php'; ?>

                <div class="wrapper ">

                    


                        <h1 class="my-4">Welcome to the Book Store</h1>
                        <?php if ($role == 'admin') : ?>
                            <h2 class="my-4">Admin Section</h2>
                            <p>Here you can manage books, users, and more.</p>
                            <a href="form_upload.php" class="btn btn-primary">Upload Book Data</a>
                        <?php endif; ?>

                        <h2 class="my-4">Books</h2>
                        <div class="row">
                            <?php
                            $sql = "SELECT buku.id_buku, buku.judul_buku, buku.harga, buku.gambar, kategori.kategori, penulis.nama_penulis, penerbit.nama_penerbit 
                                FROM buku 
                            JOIN kategori ON buku.id_kategori = kategori.id_kategori
                                JOIN penulis ON buku.id_penulis = penulis.id_penulis 
                            JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit";
                            $result = $koneksi->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_array()) {
                                    $imagePath = $row["gambar"];
                                    echo '<div class="col-md-3">
                                    <div class="ibox">
                                        <div class="ibox-content product-box">
                                            <div class="product-imitation">
                                                <img src="' . $imagePath . '" alt="' . $row["judul_buku"] . '" style="width:100%; height:600px; object-fit:cover;">
                                            </div>
                                            <div class="product-desc">
                                                <span class="product-price">$' . $row["harga"] . '</span>
                                                <small class="text-muted">' . $row["kategori"] . '</small>
                                                <a href="#" class="product-name">' . $row["judul_buku"] . '</a>
                                    <div class="small m-t-xs">
                                                    <strong>Penulis: </strong>' . $row["nama_penulis"] . '<br>
                                </div>';

                                    if ($role == 'admin') {
                                        echo    '<form action="edit_page.php" method="post">
                                    <input type="hidden" name="book_id" value="' . $row['id_buku'] . '">
                                    <button type="submit" class="btn btn-primary btn-md">Edit</button>
                                </form>
                                <form action="aksi_delete.php" method="post">
                                    <input type="hidden" name="book_id" value="' . $row['id_buku'] . '">
                                    <button type="submit" class="btn btn-danger btn-md float-right" onclick="return confirm(\'Are you sure you want to delete this book?\')">Delete</button>
                                </form>';
                                    } else {
                                        echo    '<form action="detail_product_page.php" method="POST" class="text-center">
                                    <input type="hidden" name="book_id" value="' . $row['id_buku'] . '">
                                    <button type="submit" class="btn btn-primary btn-md">Buy Now</button>
                                </form>';
                                    }
                                    echo '
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                }
                            }
                            ?>

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