<?php
session_start();
include "proses/connection.php";
$email = $_POST['email'];
$psw = $_POST['password'];
$op = $_GET['op'];
if($op=="in"){
    $sql="SELECT * FROM user where email='$email' AND password='$psw'";
    $query = $koneksi->query($sql);
    if(mysqli_num_rows($query)==1){
        $data = $query->fetch_array();
        $_SESSION['email'] = $data['email'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        if($data['role']=="admin"){
            header("location: home_page.php");
        }else if($data['role']=="user"){
            header('location: home_page.php');
        }else{
            die("password salah <a href=\"javascript:history.back()\">kembali</a>");
        }
    } else {
        // JavaScript code to display notification for incorrect email or password and redirect to login page
        echo "<script>alert('Email atau password salah!'); window.location='login.php';</script>";
    }
} else if($op=="out"){
    unset($_SESSION['username']);
    unset($_SESSION['role']);
    header('location:login.php');
}
?>
