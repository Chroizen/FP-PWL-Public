<?php

require_once '../koneksi.php';
// Definisi Variabel
$v_idTransaksi = $_POST['idTransaksi'];
$v_idJob = $_POST['idJob'];
$v_username = $_POST['username'];
$v_tanggal_transaksi = $_POST['tanggal_transaksi'];

if ($_POST['idStatusTrans'] == 1) {
  $v_idStatusTrans = "STR-1";
} else if ($_POST['idStatusTrans'] == 2) {
  $v_idStatusTrans = "STR-2";
}

// Cek Kekosongan Data
if (empty($v_idTransaksi) || empty($v_idJob) || empty($v_username) || empty($v_tanggal_transaksi)) {
  setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=trans');
  exit();
}


// Cek Ketersediaan ID Transaksi
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE idTransaksi='$v_idTransaksi'");
$temp = mysqli_num_rows($query);
if ($temp != 0) {
  // echo "Data Telah Tersedia";
  setcookie("tempinput", "ID Transaksi Telah Tersedia. Mohon inputkan ID lain yang belum tersedia.", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=trans');
  exit();
}


// Bagian Input
$query = mysqli_query($koneksi, "INSERT INTO transaksi VALUES ('$v_idTransaksi', '$v_idJob', '$v_idStatusTrans', '$v_username', '$v_tanggal_transaksi')");

if ($query) {
  setcookie("tempinput", "Input Transaksi Berhasil", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=trans');
} else {
  setcookie("tempinput", "Input Transaksi Gagal. Mungkin Kesalahan Sistem", time() + 2 * 24 * 60 * 60);
  header('location: ../?kelola=trans');
}