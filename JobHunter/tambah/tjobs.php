<?php

require_once '../koneksi.php';

// Definisi Variabel
$v_idjob = $_POST['idJob'];
$v_idkategori = $_POST['idKategori'];
// $v_thumbnail = $_POST['thumbnail'];
$v_namajob = $_POST['nama_job'];
$v_descjob = $_POST['desc_job'];
$v_hargajob = $_POST['harga_job'];

$filename = $_FILES['thumbnail']['name'];
$tmp_name = $_FILES['thumbnail']['tmp_name'];
$type = explode('.', $filename);
$type2 = $type[1];
$newname = 'thumbnail jobs - ' . time() . '.' . $type2;

// menampung data format yang diijinkan
$ekstensi = array('jpg', 'jpeg', 'png', 'gif');

// validasi format file
if (!in_array($type2, $ekstensi)) {
  echo "<script>
  alert('Format File Salah. Ganti ke jpg, jpeg, png, gif');
  </script>";
} else {

  move_uploaded_file($tmp_name, 'assets/img/thumbnail/' . $newname);

  // Cek Kekosongan Data
  // if (empty($v_idjob) || empty($v_idkategori) || empty($v_thumbnail) || empty($v_namajob) || empty($v_descjob) || empty($v_hargajob)) {
  //   setcookie("tempinput", "Ada data yang kosong", time() + 2 * 24 * 60 * 60);
  //   header('location:../index.php?kelola=jobs');
  //   exit();
  // }

  // Cek Ketersediaan ID Job
  // $query = mysqli_query($koneksi, "SELECT * FROM jobs WHERE idJob='$v_idjob'");
  // $temp = mysqli_num_rows($query);
  // if ($temp != 0) {
  //   // echo "Data Telah Tersedia";
  //   setcookie("tempinput", "ID Job Telah Tersedia. Inputkan ID lain", time() + 2 * 24 * 60 * 60);
  //   header('location: ../index.php?kelola=jobs');
  //   exit();
  // }

  // Bagian Input
  $query = mysqli_query($koneksi, "INSERT INTO jobs VALUES ('$v_idjob', '$v_idkategori', '$newname', '$v_namajob', '$v_descjob', '$v_hargajob')") or die(mysqli_error($koneksi));

  if ($query) {
    setcookie("tempinput", "Input Job Baru Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=jobs');
  } else {
    // mysqli_error($query);
    setcookie("tempinput", "Input Job Baru Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=jobs');
  }
}