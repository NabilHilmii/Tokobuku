<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user ID
$sql = "SELECT id_user FROM user WHERE username = '" . $koneksi->real_escape_string($username) . "'";
$result = $koneksi->query($sql);
$user = $result->fetch_assoc();
$user_id = intval($user['id_user']);

// Fetch cart items for the user
$sql = "SELECT buku.harga,buku.sinopsis,buku.gambar,keranjang.* FROM keranjang 
JOIN buku ON buku.id_buku=keranjang.id_buku
WHERE id_user = $user_id";
$result = $koneksi->query($sql);
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
                <div class="row">
                    <div class="col-md-9">
                        <div class="ibox">
                            <div class="ibox-title">
                                <span class="pull-right">(<strong><?php echo $result->num_rows; ?></strong>) items</span>
                                <h5>Items in your cart</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <form action="aksi_hapus_keranjang.php" method="POST">
                                        <table class="table shoping-cart-table">
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <td style="vertical-align: middle;">
                                                                <input type="checkbox" name="cart_ids[]" value="<?php echo $row['id_keranjang']; ?>">
                                                            </td>
                                                            <td width="90">
                                                                <div class="cart-product-imitation">
                                                                    <img src="<?php echo ($row['gambar']); ?>" alt="Book Image" style="width: 70px; height: 70px;">
                                                                </div>
                                                            </td>
                                                            <td class="desc">
                                                                <h3>
                                                                    <a href="#" class="text-navy">
                                                                        <?php echo ($row['judul_buku']); ?>
                                                                    </a>
                                                                </h3>
                                                                <dl class="small m-b-none">
                                                                    <dt>Description</dt>
                                                                    <dd><?php echo $row['sinopsis']; ?></dd>
                                                                </dl>
                                                            </td>
                                                            <td>
                                                                Rp. <?php echo number_format($row['harga']); ?>
                                                            </td>
                                                            <td>
                                                                <!-- Form untuk tombol minus -->
                                                                <form action="update_jumlah_keranjang.php" method="POST">
                                                                    <input type="hidden" name="cart_id" value="<?php echo $row['id_keranjang']; ?>">
                                                                    <input type="hidden" name="book_id" value="<?php echo $row['id_buku']; ?>">
                                                                    <input type="hidden" name="action" value="minus">
                                                                    <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-minus"></i></button>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['jumlah']; ?>
                                                            </td>
                                                            <td>
                                                                <!-- Form untuk tombol plus -->
                                                                <form action="update_jumlah_keranjang.php" method="POST">
                                                                    <input type="hidden" name="cart_id" value="<?php echo $row['id_keranjang']; ?>">
                                                                    <input type="hidden" name="book_id" value="<?php echo $row['id_buku']; ?>">
                                                                    <input type="hidden" name="action" value="plus">
                                                                    <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-plus"></i></button>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <h4>
                                                                    Rp.<?php echo number_format($row['harga'] * $row['jumlah']); ?>
                                                                </h4>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='9' class='text-center'>No items in your cart.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-danger btn-sm">Remove Selected Items</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Cart Summary</h5>
                            </div>
                            <div class="ibox-content">
                                <?php
                                // Calculate total
                                $sql = "SELECT SUM(buku.harga * keranjang.jumlah) as total FROM keranjang 
                                JOIN buku ON buku.id_buku=keranjang.id_buku
                                WHERE id_user = $user_id";
                                $result = $koneksi->query($sql);
                                $total = $result->fetch_assoc()['total'];
                                ?>
                                <span>
                                    Total
                                </span>
                                <h2 class="font-bold">
                                    Rp.<?php echo ($total); ?>
                                </h2>

                                <hr />

                                <div class="m-t-sm">
                                    <div class="text-right">
                                        <form action="aksi_checkout.php" method="post">
                                            <button type="submit" name="checkout_and_delete" class="btn btn-primary btn-sm">
                                                <i class="fa fa-shopping-cart"></i> Checkout
                                            </button>
                                        </form>
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
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
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