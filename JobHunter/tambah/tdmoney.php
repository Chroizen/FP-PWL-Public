<?php

require_once '../koneksi.php';
// Definisi Variabel
$v_idDigitalMoney = $_POST['idDigitalMoney'];
$v_username = $_POST['username'];
$v_jumlahsaldo = $_POST['jumlahSaldo'];

// Cek Kekosongan Data
if (empty($v_idDigitalMoney) || empty($v_username) || empty($v_jumlahsaldo)) {
  setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=dmoney');
  exit();
}


// Cek Ketersediaan Username
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$v_username'");
$temp = mysqli_num_rows($query);
if ($temp != $v_username) {
  setcookie("tempinput", "Username Tidak Tersedia, silahkan edit saja yang ada", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=dmoney');
  exit();
}

// Cek Ketersediaan ID
$query = mysqli_query($koneksi, "SELECT * FROM digitalmoney WHERE idDigitalMoney='$v_idDigitalMoney'");
$temp = mysqli_num_rows($query);
if ($temp != $v_idDigitalMoney) {
  // echo "ID Telah Tersedia, gunakan ID lain";
  setcookie("tempinput", "ID Tidak Tersedia. Gunakan ID lain", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=dmoney');
  exit();
}


// Bagian Input
$query = mysqli_query($koneksi, "INSERT INTO digitalmoney (idDigitalMoney, username, jumlahSaldo) VALUES ('$v_idDigitalMoney', '$v_username', '$v_jumlahsaldo')") or die(mysqli_error($koneksi));

if ($query) {
  setcookie("tempinput", "Input Digital Money Baru Berhasil", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=dmoney');
} else {
  setcookie("tempinput", "Input Digital Money Baru Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=dmoney');
}