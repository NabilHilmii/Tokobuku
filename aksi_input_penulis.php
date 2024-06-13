<?php
session_start();
include 'proses/connection.php';

$nama=$_POST['nama_penulis'];
$sql="INSERT INTO penulis(nama_penulis) VALUES ('".$nama."')";
$query=$koneksi->query($sql);
if ($query==true) {
    header('location: input_penulis_page.php');
} else {
   echo "error";
}
?>
