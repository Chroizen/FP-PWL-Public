<?php

require_once '../koneksi.php';

// Definisi Variabel
$v_idStatusUser = $_POST['idStatusUser'];
$v_namaStatus = $_POST['namaStatus'];

// Cek Kekosongan Data
if (empty($v_idStatusUser) || empty($v_namaStatus)) {
  setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=stauser');
  exit();
}


// Cek Ketersediaan ID
$query = mysqli_query($koneksi, "SELECT * FROM statususer WHERE idStatusUser='$v_idStatusUser'");
$temp = mysqli_num_rows($query);
if ($temp != 0) {
  echo "Data Telah Tersedia";
  setcookie("tempinput", "ID Telah Tersedia. Input Gagal", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=stauser');
  exit();
}


// Bagian Input
$query = mysqli_query($koneksi, "INSERT INTO statususer (idStatusUser, namaStatus) VALUES ('$v_idStatusUser', '$v_namaStatus')");

if ($query) {
  setcookie("tempinput", "Input Status Akun User Baru Berhasil", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=stauser');
} else {
  setcookie("tempinput", "Input Status Akun User Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=stauser');
}