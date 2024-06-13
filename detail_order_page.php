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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wrapper wrapper-content animated fadeInRight">
                            <div class="ibox-content p-xl">


                                <div class="table-responsive m-t">
                                    <table class="table invoice-table">
                                        <thead>
                                            <tr>
                                                <th>Item List</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $username = $_SESSION['username'];
                                            $id_pembelian = $_POST['id_pembelian'];
                                            $sql = "SELECT invoice.id_pembelian,buku.id_buku, invoice.judul_buku, invoice.harga, invoice.jumlah as total_jumlah, (buku.harga * SUM(invoice.jumlah)) as total_harga
                                            FROM invoice                                                
                                            JOIN buku ON invoice.id_buku = buku.id_buku                                                
                                            JOIN pembelian ON pembelian.id_pembelian = invoice.id_pembelian
                                            JOIN pembayaran ON pembayaran.id_detail = invoice.id_detail                                       
                                            WHERE pembelian.username = '$username' AND invoice.id_pembelian = '$id_pembelian'
                                            GROUP BY pembayaran.id_pembayaran;";
                                            $result = $koneksi->query($sql); ?>
                                            <?php while ($row = $result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?php echo $row['judul_buku']; ?></td>
                                                    <td><?php echo $row['total_jumlah']; ?></td>
                                                    <td>Rp.<?php echo number_format($row['harga'], 2, ',', '.'); ?></td>
                                                    <td>Rp.<?php echo number_format($row['total_harga'], 2, ',', '.'); ?></td>
                                                </tr>
                                            <?php } ?>


                                        </tbody>
                                    </table>
                                </div><!-- /table-responsive -->

                                <table class="table invoice-total">
                                    <tbody>
                                        <?php
                                        $sql = "SELECT SUM(buku.harga * invoice.jumlah) as total 
                                    FROM invoice
                                    JOIN buku ON buku.id_buku = invoice.id_buku
                                    JOIN pembelian ON invoice.id_pembelian = pembelian.id_pembelian
                                    WHERE pembelian.username = '$username' AND invoice.id_pembelian='$id_pembelian'";
                                        $result = $koneksi->query($sql);
                                        $total = $result->fetch_assoc()['total'];
                                        ?>

                                        <tr>
                                            <td><strong>TOTAL :</strong></td>
                                            <td>Rp.<?php echo number_format($total, 2, ',', '.'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-right">
                                    <?php
                                    // Check if the payment status is already "Dibayar"
                                    
                                    $id_pembelian = $_POST['id_pembelian'];
                                    $sql = "SELECT status FROM pembayaran 
                                        JOIN invoice ON pembayaran.id_detail = invoice.id_detail 
                                        JOIN pembelian ON invoice.id_pembelian = pembelian.id_pembelian 
                                        WHERE pembelian.username = '$username' AND pembayaran.status = 'Tidak Dibayar'";
                                    $result = $koneksi->query($sql);
                                
                                        
                                        echo '<div class="btn-group">
                                                        <form action="aksi_bayar.php" method="POST" style="display:inline;">
                                                            <!-- Hidden input to send order id or any necessary data -->
                                                            <input type="hidden" name="id_pembelian" value="' . $id_pembelian . '">
                                                            <button type="submit" class="btn btn-primary">Bayar</button>
                                                        </form>
                                                    </div>';
                                    
                                    ?>
                                </div>

                                <div class="well m-t"><strong>Comments</strong>
                                    It is a long established fact that a reader will be distracted by the readable content of
                                    a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
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