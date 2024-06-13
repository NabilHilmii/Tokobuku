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
                        <div class="ibox">
                            <div class="ibox-content">

                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th data-hide="phone">Customer</th>
                                            <th data-hide="phone">Amount</th>
                                            <th data-hide="phone">Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $username = $_SESSION['username'];
                                        $sql = "SELECT 
                                                    pembelian.id_pembelian,
                                                    pembelian.username,
                                                    pembayaran.status,
                                                    SUM(invoice.jumlah) AS total_jumlah,
                                                    SUM(buku.harga * invoice.jumlah) AS total_harga
                                                FROM 
                                                    invoice
                                                JOIN 
                                                    buku ON invoice.id_buku = buku.id_buku
                                                JOIN 
                                                    pembelian ON pembelian.id_pembelian = invoice.id_pembelian
                                                JOIN 
                                                    pembayaran ON pembayaran.id_detail = invoice.id_detail
                                                WHERE 
                                                    pembelian.username = '$username'
                                                GROUP BY 
                                                    pembelian.id_pembelian, pembelian.username, pembayaran.status";
                                        $result = $koneksi->query($sql);

                                        ?>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['id_pembelian']; ?></td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td>Rp.<?php echo number_format($row['total_harga']); ?></td>
                                                <td>
                                                    <span class="label label-primary"><?php echo $row['status']; ?></span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <form action="detail_order_page.php" method="POST" style="display:inline;">
                                                            <!-- Hidden input to send order id or any necessary data -->
                                                            <input type="hidden" name="id_pembelian" value="<?php echo $row['id_pembelian']; ?>">
                                                            <button type="submit" class="btn btn-success btn-xs">Detail</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
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
