<?php
require('koneksi.php');


$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$nama_lengkap = $_POST['nama_lengkap'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];
// $idStatusUser = $_POST['idStatusUser'];
$idStatusUser = filter_input(INPUT_POST, 'idStatusUser', FILTER_SANITIZE_STRING);





// Validasi Auth Password
if ($password != $password2) {
	setcookie("tempinput", "Konfirmasi Password harus sama dengan password yang diinputkan.", time() + 2 * 24 * 60 * 60);
	// header('location: register.php');
}

// Validasi ketersediaan ID
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'") or die($koneksi);
$rows = mysqli_num_rows($query);

if ($rows != 0) {
	setcookie("tempinput", "Username Telah tersedia. Harap gunakan username lain", time() + 2 * 24 * 60 * 60);
	header('location: register.php');
}




$query = mysqli_query($koneksi, "INSERT INTO user 
	(username, password, nama_lengkap, email, no_hp, alamat, idStatusUser) 
	VALUES 
	('$username', '$password', '$nama_lengkap', '$email', '$no_hp', '$alamat', '$idStatusUser')") or die($koneksi);




if ($query) {
	setcookie("tempinput", "Register Berhasil. Sekarang anda dapat Login", time() + 2 * 24 * 60 * 60);
	header('location: login.php');
} else {
	setcookie("tempinput", "Register gagal, hubungi admin.", time() + 2 * 24 * 60 * 60);
	header('location: register.php');
}


?>