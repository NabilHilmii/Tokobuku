<?php
session_start();
include 'proses/connection.php';

$id=$_POST['id_kategori'];
$nama=$_POST['kategori'];
$sql="UPDATE  kategori  SET kategori='$nama' WHERE id_kategori='$id'";
$query=$koneksi->query($sql);
if ($query==true) {
    header('location: input_kategori_page.php');
} else {
   echo "error";
}
?>