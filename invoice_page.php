<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil data pembayaran untuk pengguna yang sedang login
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
            pembelian.id_pembelian, pembayaran.status";

$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Page</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <!-- Navbar Section -->
        <?php include 'user_navbar.php'; ?>
        <!-- Page Content -->
        <div id="page-wrapper" class="gray-bg">
            <!-- Top Navbar -->
            <?php include 'top_navbar.php'; ?>

            <div class="wrapper wrapper-content">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="ibox">

                            <div class="ibox-content">
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <div class="row">

                                            <div class="col-lg-12">

                                                <div class="wrapper wrapper-content animated fadeInRight">

                                                    <div class="ibox-content p-xl">

                                                        <!-- Invoice Details -->
                                                        <div class="row">

                                                            <div class="col-sm-6 text-left">
                                                                <h4>Invoice No. <?php echo $row['id_pembelian']; ?></h4>
                                                                <address>
                                                                    <!-- Address Details -->
                                                                </address>
                                                                <p>
                                                                    <span><strong>Invoice Date:</strong> Marh 18, 2014</span><br />
                                                                    <span><strong>Due Date:</strong> March 24, 2014</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <!-- Invoice Items -->
                                                        <div class="table-responsive m-t">
                                                            <table class="table invoice-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Item List</th>
                                                                        <th>Quantity</th>
                                                                        <th>Unit Price</th>
                                                                        <th>Total Price</th>
                                                                        <th>Download Link</th> <!-- Added a column for download link -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    // Ambil data item untuk invoice tertentu
                                                                    $id_pembelian = $row['id_pembelian'];
                                                                    $item_query = "SELECT buku.judul_buku, invoice.jumlah, buku.harga, buku.pdf, invoice.downloads
                                                                                    FROM invoice
                                                                                    JOIN buku ON invoice.id_buku = buku.id_buku
                                                                                    WHERE invoice.id_pembelian = '$id_pembelian'";
                                                                    $item_result = $koneksi->query($item_query);

                                                                    // Tampilkan item-item dalam invoice
                                                                    while ($item_row = $item_result->fetch_assoc()) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $item_row['judul_buku']; ?></td>
                                                                            <td><?php echo $item_row['jumlah']; ?></td>
                                                                            <td><?php echo $item_row['harga']; ?></td>
                                                                            <td><?php echo $item_row['jumlah'] * $item_row['harga']; ?></td>
                                                                            <td>
                                                                                <?php if ($row['status'] == 'Dibayar') : ?>
                                                                                    <?php if ($item_row['downloads'] < $item_row['jumlah']) : ?>
                                                                                        <form action="aksi_download.php" method="post">
                                                                                            <input type="hidden" name="pdf" value="<?php echo $item_row['pdf']; ?>">
                                                                                            <input type="hidden" name="invoice_id" value="<?php echo $id_pembelian; ?>">
                                                                                            <button type="submit" class="btn btn-success">Download</button>
                                                                                        </form>
                                                                                    <?php else : ?>
                                                                                        <span class="text-danger">Download Limit Reached</span>
                                                                                    <?php endif; ?>
                                                                                <?php else : ?>
                                                                                    <span class="text-danger">Payment Pending</span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <!-- Add more rows for additional items if needed -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- Total Amount -->
                                                        <table class="table invoice-total">
                                                            <tbody>
                                                                <tr>
                                                                    <td><strong>TOTAL :</strong></td>
                                                                    <td>$<?php echo $row['total_harga']; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    // Display a message if no payment data is found
                                    echo "<p>No payment data found.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Section -->
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
    <!-- JavaScript Section -->
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