<?php
session_start();
include 'proses/connection.php';

$id=$_GET['id_penulis'];
$sql="DELETE FROM penulis  WHERE id_penulis='$id'";
$query=$koneksi->query($sql);
if ($query==true) {
    header('location: input_penulis_page.php');
} else {
   echo "error";
}
?>