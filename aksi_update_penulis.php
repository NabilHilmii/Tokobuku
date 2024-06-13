<?php
session_start();
include 'proses/connection.php';

$id=$_POST['id_penulis'];
$nama=$_POST['nama_penulis'];
$sql="UPDATE  penulis  SET nama_penulis='$nama' WHERE id_penulis='$id'";
$query=$koneksi->query($sql);
if ($query==true) {
    header('location: input_penulis_page.php');
} else {
   echo "error";
}
?>