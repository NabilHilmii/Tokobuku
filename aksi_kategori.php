<?php
session_start();
include 'proses/connection.php';


if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil parameter kategori dari URL jika ada
$kategoriDipilih = '';
if (!empty($_GET['kategori'])) {
    $kategoriDipilih = $_GET['kategori'];
}

// Query untuk mengambil semua kategori
$queryKategori = "SELECT DISTINCT kategori, gambar FROM kategori";
$resultKategori = $koneksi->query($queryKategori);

// Jika kategori dipilih, ambil barang berdasarkan kategori
if ($kategoriDipilih) {
    $queryBarang = "SELECT judul_buku,gambar,kategori,penulis FROM buku WHERE id_kategori = '$kategoriDipilih'";
    $resultBarang = $koneksi->query($queryBarang);
}
?>