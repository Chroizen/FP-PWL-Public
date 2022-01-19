<?php
$koneksi = mysqli_connect("localhost", "root", "") or die("Koneksi gagal");

mysqli_select_db($koneksi, "jobhunter") or die("Database belum ada silakan import database");