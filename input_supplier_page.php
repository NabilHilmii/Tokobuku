<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
    <?php include 'admin_navbar.php'; ?>  
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
            <?php include 'top_navbar.php'; ?>
            </div>

            <div class="wrapper wrapper-content">
                <a data-toggle="modal" class="btn btn-primary" href="#modal-input-form">Input Supplier</a>
                <div id="modal-input-form" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="text-center">
                                        <h3 class="m-t-none m-b">Input Supplier</h3>
                                        <form role="form" action="aksi_input_supplier.php" method="post">
                                            <div class="form-group">
                                                <label>Nama Supplier</label>
                                                <input type="text" name="nama_supplier" class="form-control" required />
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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                    <thead>
                                        <tr>
                                            <th data-toggle="true">No.</th>
                                            <th data-toggle="true">Nama Supplier</th>
                                            <th class="text-right" data-sort-ignore="true">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $sql = "SELECT id_supplier, nama FROM supplier";
                                        $result = $koneksi->query($sql);
                                        ?>
                                        <?php
                                        while ($row = $result->fetch_array()) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row['nama']; ?></td>
                                                <td class="text-right">
                                                    <div>
                                                        <a data-toggle="modal" class="btn btn-primary" href="#modal-edit-form-<?php echo $row['id_supplier']; ?>">Edit</a>
                                                        <div id="modal-edit-form-<?php echo $row['id_supplier']; ?>" class="modal fade" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="text-center">
                                                                                <h3 class="m-t-none m-b">Edit Penulis</h3>
                                                                                <form role="form" action="aksi_update_supplier.php" method="post">
                                                                                    <div class="form-group">
                                                                                        <label>Nama penulis</label>
                                                                                        <input type="hidden" name="id_supplier" value="<?php echo $row['id_supplier']; ?>" />
                                                                                        <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>" required />
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <button type="submit" class="btn btn-primary">Edit</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
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
