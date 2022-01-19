<?php
error_reporting(0);
require_once 'koneksi.php';
$kelola = htmlspecialchars($_GET['kelola']);
switch ($kelola) {
  case null:
    include 'kelola/dashboard.php';
    break;
  case 'admin':
    include 'kelola/admin.php';
    break;
  case 'user':
    include 'kelola/user.php';
    break;
  case 'trans':
    include 'kelola/trans.php';
    break;
  case 'dmoney':
    include 'kelola/dmoney.php';
    break;
  case 'faq':
    include 'kelola/faq.php';
    break;
  case 'jobs':
    include 'kelola/jobs.php';
    break;
  case 'ktjobs':
    include 'kelola/ktjobs.php';
    break;
  case 'review':
    include 'kelola/review.php';
    break;
  case 'statrans':
    include 'kelola/statrans.php';
    break;
  case 'stauser':
    include 'kelola/stauser.php';
    break;
  case 'report':
    include 'kelola/report.php';
    break;
  case 'cetak_trans':
    include 'kelola/cetak_trans.php';
    break;
  default:
    break;
}