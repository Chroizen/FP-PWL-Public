<?php
require_once '../koneksi.php';
// step 1 : tampung input dari form
// Definisi Variabel
$v_username = $_POST['usernameAdmin'];
$v_password = $_POST['password'];
$v_fulln = $_POST['nama_lengkap'];
$v_email = $_POST['email'];
$v_nohp = $_POST['no_hp'];
$v_alamat = $_POST['alamat'];

// Cek Kekosongan Data
if (empty($v_username) || empty($v_password) || empty($v_fulln) || empty($v_email) || empty($v_nohp) || empty($v_alamat)) {
  setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=admin');
  exit();
}

// Cek Ketersediaan Username
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE usernameAdmin='$v_username'");
$temp = mysqli_num_rows($query);
if ($temp != 0) {
  echo "Data Telah Tersedia";
  setcookie("tempinput", "Username Telah Tersedia. Input Gagal", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=admin');
  exit();
}


// Bagian Input

$query = mysqli_query($koneksi, "INSERT INTO admin (usernameAdmin, password, nama_lengkap, email, no_hp, alamat) VALUES ('$v_username', '$v_password', '$v_fulln', '$v_email', '$v_nohp', '$v_alamat')");

if ($query) {
  setcookie("tempinput", "Input Akun Admin Baru Berhasil", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=admin');
  // include 
} else {
  setcookie("tempinput", "Input Akun Admin Baru Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=admin');
}