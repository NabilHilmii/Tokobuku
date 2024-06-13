<?php
session_start();
include 'proses/connection.php';

$nama=$_POST['kategori'];
$sql="INSERT INTO kategori(kategori) VALUES ('".$nama."')";
$query=$koneksi->query($sql);
if ($query==true) {
    header('location: input_kategori_page.php');
} else {
   echo "error";
}
?>
