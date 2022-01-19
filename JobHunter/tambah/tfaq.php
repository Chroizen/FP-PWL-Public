<?php

require_once '../koneksi.php';

// Definisi Variabel
$v_idFaq = $_POST['idFaq'];
$v_usernameAdmin = $_POST['usernameAdmin'];
$v_namaFaq = $_POST['namaFaq'];
$v_desc_faq = $_POST['desc_faq'];

// Cek Kekosongan Data
if (empty($v_idFaq) || empty($v_usernameAdmin) || empty($v_namaFaq) || empty($v_desc_faq)) {
  setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=faq');
  exit();
}


// Cek Ketersediaan ID
$query = mysqli_query($koneksi, "SELECT * FROM faq WHERE idFaq='$v_idFaq'");
$temp = mysqli_num_rows($query);
if ($temp != 0) {
  echo "ID Telah Tersedia";
  setcookie("tempinput", "ID Telah Tersedia. Input Gagal", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=faq');
  exit();
}

// Cek Ketersediaan User
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE usernameAdmin='$v_usernameAdmin'");
$temp = mysqli_num_rows($query);
if ($temp == 0) {
  echo "Username Admin Yang Di-inputkan Harus Tersedia";
  setcookie("tempinput", "Username Admin Harus Tersedia Sebelum menginput", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=faq');
  exit();
}

// Bagian Input
$query = mysqli_query($koneksi, "INSERT INTO faq (idFaq, usernameAdmin, namaFaq, desc_faq) VALUES ('$v_idFaq', '$v_usernameAdmin', '$v_namaFaq', '$v_desc_faq')");

if ($query) {
  setcookie("tempinput", "Input FaQ Baru Berhasil", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=faq');
} else {
  setcookie("tempinput", "Input FaQ Baru Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=faq');
}