<?php

require_once '../koneksi.php';

// Definisi Variabel
$v_idStatusTrans = $_POST['idStatusTrans'];
$v_StatusTrans = $_POST['StatusTrans'];

// Cek Kekosongan Data
if (empty($v_idStatusTrans) || empty($v_StatusTrans)) {
  setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=statrans');
  exit();
}

// Cek Ketersediaan ID
$query = mysqli_query($koneksi, "SELECT * FROM statustransaksi WHERE idStatusTrans='$v_idStatusTrans'");
$temp = mysqli_num_rows($query);
if ($temp != 0) {
  echo "ID Telah Tersedia";
  setcookie("tempinput", "ID Telah Tersedia. Input Gagal", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=statrans');
  exit();
}


// Bagian Input
$query = mysqli_query($koneksi, "INSERT INTO statustransaksi (idStatusTrans, StatusTrans) VALUES ('$v_idStatusTrans', '$v_StatusTrans')");

if ($query) {
  setcookie("tempinput", "Input Status Transaksi Berhasil", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=statrans');
} else {
  setcookie("tempinput", "Input Status Transaksi Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=statrans');
}