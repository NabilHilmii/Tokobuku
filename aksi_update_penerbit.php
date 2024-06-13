<?php
session_start();
include 'proses/connection.php';

$id=$_POST['id_penerbit'];
$nama=$_POST['nama_penerbit'];
$alamat=$_POST['alamat'];
$sql="UPDATE  penerbit  SET nama_penerbit='$nama', alamat='$alamat' WHERE id_penerbit='$id'";
$query=$koneksi->query($sql);
if ($query==true) {
    header('location:input_penerbit_page.php');
} else {
   echo "error";
}
?>