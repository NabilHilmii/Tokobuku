<?php
session_start();
include 'proses/connection.php';

$nama=$_POST['nama_penerbit'];
$sql="INSERT INTO penerbit(nama_penerbit) VALUES ('".$nama."')";
$query=$koneksi->query($sql);
if ($query==true) {
    header('location: input_penerbit_page.php');
} else {
   echo "error";
}
?>
