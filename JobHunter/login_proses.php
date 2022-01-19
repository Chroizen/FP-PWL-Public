<?php
require('koneksi.php');


$username = $_POST['username'];
$password = $_POST['password'];





$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'") or die($koneksi);
$rows = mysqli_num_rows($query);




if ($rows != 0) {
	// Cek Level User
	$array = mysqli_fetch_array($query);
	if ($array['idStatusUser'] == 'STU-1') {
		setcookie("account_level", "Penjual", time() + 2 * 24 * 60 * 60);
		setcookie("akses_jual", "Penjual", time() + 2 * 24 * 60 * 60);
		setcookie("account_username", $username, time() + 2 * 24 * 60 * 60);
		$_COOKIE['account_level'] = "Penjual";
		$_COOKIE['akses_jual'] = "Penjual";
		$_COOKIE['account_username'] = $username;
	}
	if ($array['idStatusUser'] == 'STU-2') {
		setcookie("account_level", "Pembeli", time() + 2 * 24 * 60 * 60);
		setcookie("akses_jual", "Pembeli", time() + 2 * 24 * 60 * 60);
		setcookie("account_username", $username, time() + 2 * 24 * 60 * 60);
		$_COOKIE['account_level'] = "Pembeli";
		$_COOKIE['akses_jual'] = "Pembeli";
		$_COOKIE['account_username'] = $username;
	}



} else if ($rows == 0) {
	// Cek Admin Apabila data User tidak tersedia
	$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE usernameAdmin='$username' AND password='$password'") or die($koneksi);
	$rows = mysqli_num_rows($query);

	// Apabila data ditemukan
	if ($rows != 0) {
		setcookie("account_level", "Admin", time() + 2 * 24 * 60 * 60);
		setcookie("account_username", $username, time() + 2 * 24 * 60 * 60);
		$_COOKIE['account_level'] = "Admin";
		$_COOKIE['account_username'] = $username;
	}
}


// Cek Kekosongan Data
if (!isset($_COOKIE['account_username'])) {
	// setcookie("tempinput", "Data Login Tidak Ditemukan", time() + 2 * 24 * 60 * 60);
	setcookie("error", true, time() + 2 * 24 * 60 * 60);
	header('location: login.php');
}


// Script Redirect
if ($_COOKIE['account_level'] == "Admin") {
	header('location: index.php');
} else if ($_COOKIE['account_level'] == "Pembeli") {
	header('location: dashboard/index.php');
} else if ($_COOKIE['account_level'] == "Penjual"){
	header('location: penjualan/index.php');
}


?>