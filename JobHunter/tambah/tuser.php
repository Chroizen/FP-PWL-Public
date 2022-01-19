<?php

require_once '../koneksi.php';

// Definisi Variabel
$v_username = $_POST['username'];
$v_password = $_POST['password'];
$v_fulln = $_POST['nama_lengkap'];
$v_email = $_POST['email'];
$v_nohp = $_POST['no_hp'];
$v_alamat = $_POST['alamat'];

if ($_POST['idStatusUser'] == 1) {
  $v_idStatusUser = "STU-1";
} else if ($_POST['idStatusUser'] == 2) {
  $v_idStatusUser = "STU-2";
}

// Cek Kekosongan Data
if (empty($v_username) || empty($v_password) || empty($v_fulln) || empty($v_email) || empty($v_nohp) || empty($v_alamat)) {
  setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=user');
  exit();
}

// echo $v_username;
// echo "<br>";
// echo $v_password;
// echo "<br>";
// echo $v_fulln;
// echo "<br>";
// echo $v_email;
// echo "<br>";
// echo $v_nohp;
// echo "<br>";
// echo $v_alamat;
// echo "<br>";
// echo $v_idStatusUser;


// Cek Ketersediaan Username
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$v_username'");
$temp = mysqli_num_rows($query);
if ($temp != 0) {
  echo "Data Telah Tersedia";
  setcookie("tempinput", "Username Telah Tersedia. Input Gagal", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=user');
  exit();
}


// Bagian Input
$query = mysqli_query($koneksi, "INSERT INTO user (username, password, nama_lengkap, email, no_hp, alamat, idStatusUser) VALUES ('$v_username', '$v_password', '$v_fulln', '$v_email', '$v_nohp', '$v_alamat', '$v_idStatusUser')");

if ($query) {
  setcookie("tempinput", "Input Berhasil", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=user');
} else {
  setcookie("tempinput", "Input Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=user');
}