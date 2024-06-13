<?php
session_start();
include 'proses/connection.php';

$id=$_POST['id_supplier'];
$nama=$_POST['nama'];
$sql="UPDATE  supplier  SET nama='$nama' WHERE id_supplier='$id'";
$query=$koneksi->query($sql);
if ($query==true) {
    header('location: input_supplier_page.php');
} else {
   echo "error";
}
?>