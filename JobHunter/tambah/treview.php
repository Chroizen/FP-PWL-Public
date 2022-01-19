<?php

require_once '../koneksi.php';

// Definisi Variabel
$v_idReview = $_POST['idReview'];
$v_idJob = $_POST['idJob'];
$v_username = $_POST['username'];
$v_desc_review = $_POST['desc_review'];
$v_rating = $_POST['rating'];

// Cek Kekosongan Data
if (empty($v_idReview) || empty($v_idJob) || empty($v_username) || empty($v_desc_review) || empty($v_rating)) {
  setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=review');
  exit();
}


// Cek Ketersediaan ID
$query = mysqli_query($koneksi, "SELECT * FROM review WHERE idReview='$v_idReview'");
$temp = mysqli_num_rows($query);
if ($temp != 0) {
  echo "Data Telah Tersedia";
  setcookie("tempinput", "ID Telah Tersedia. Input Gagal", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=review');
  exit();
}

// Cek Ketersediaan User
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$v_username'");
$temp = mysqli_num_rows($query);
if ($temp == 0) {
  echo "Username Harus Tersedia Sebelum menginput";
  setcookie("tempinput", "Username Harus Tersedia Sebelum menginput", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=review');
  exit();
}


// Bagian Input
$query = mysqli_query($koneksi, "INSERT INTO review (idReview, idJob, username, desc_review, rating) VALUES ('$v_idReview', '$v_idJob', '$v_username', '$v_desc_review', '$v_rating')") or die(mysqli_error($koneksi));

if ($query) {
  setcookie("tempinput", "Input Review Baru Berhasil", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=review');
} else {
  setcookie("tempinput", "Input Review Baru Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
  header('location: ../index.php?kelola=review');
}