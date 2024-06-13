<?php
session_start();
include 'proses/connection.php';

$nama=$_POST['nama_supplier'];
$sql="INSERT INTO supplier(nama) VALUES ('".$nama."')";
$query=$koneksi->query($sql);
if ($query==true) {
    header('location: input_supplier_page.php');
} else {
   echo "error";
}
?>
