<?php
// sidebar.php



// Include file koneksi ke database
include "proses/connection.php";
?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.css" rel="stylesheet">

<!-- FooTable -->
<link href="css/plugins/footable/footable.core.css" rel="stylesheet">

<link href="css/animate.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">



<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <?php
                $email=$_SESSION['email'];
                $sql = "SELECT * FROM user WHERE email='$email'";
                $query = $koneksi->query($sql);
                $user = $query->fetch_assoc();
                if ($user) {
                    $username = $user['username'];
                    $profile_image = $user['foto']; ?>
                    <div class="text-center">
                        <span>
                            <img alt="image" class="img-circle" src="<?php echo $profile_image; ?>" style="width:100px; height:100px; object-fit:cover; margin: 10px;"/> <!-- Tampilkan foto profil -->
                        </span>
                        <a data-toggle="dropdown" class="text-center" href="#">
                            <span class="clear">
                                <span class="block m-t-xs"> <strong class="font-bold"><?php echo $username; ?></strong> <!-- Tampilkan nama pengguna -->
                                </span>
                                
                            </span>
                        </a>
                    </div>
                <?php } ?>
                
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li>
                <a href="home_page.php"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
            </li>
            <li>
                <a href="kategori_page.php"><i class="fa fa-tags"></i> <span class="nav-label">Kategori</span></a>
            </li>

            <li>
                <a href="keranjang_page.php"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Keranjang</span></a>
            </li>

            <li>
                <a href="order_page.php"><i class="fa fa-dollar"></i> <span class="nav-label">Pembayaran</span></a>
            </li>
            <li>
                <a href="invoice_page.php"><i class="fa fa-barcode"></i> <span class="nav-label">Invoice</span></a>
            </li>
            <li>
                <a href="Ulasan_page.php"><i class="fa fa-barcode"></i> <span class="nav-label">Ulasan</span></a>
            </li>
            
        </ul>
    </div>
</nav>
