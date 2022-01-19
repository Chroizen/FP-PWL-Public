<?php

require_once '../koneksi.php';

// Definisi Variabel
$v_idKategori = $_POST['idKategori'];
$v_namaKategori = $_POST['namaKategori'];

// Cek Kekosongan Data
if (empty($v_idKategori) || empty($v_namaKategori)) {
  setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=ktjobs');
  exit();
}


// Cek Ketersediaan ID
$query = mysqli_query($koneksi, "SELECT * FROM kategorijobs WHERE idKategori='$v_idKategori'");
$temp = mysqli_num_rows($query);
if ($temp != 0) {
  // echo "ID Telah Tersedia";
  setcookie("tempinput", "ID Telah Tersedia. Silahkan Input ID Lain", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=ktjobs');
  exit();
}


// Bagian Input
$query = mysqli_query($koneksi, "INSERT INTO kategorijobs (idKategori, namaKategori) VALUES ('$v_idKategori', '$v_namaKategori')");

if ($query) {
  setcookie("tempinput", "Input Kategori Baru Berhasil", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=ktjobs');
} else {
  setcookie("tempinput", "Input Kategori Baru Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=ktjobs');
}