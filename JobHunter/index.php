<!DOCTYPE html>
<html lang="en">

<?php
include 'koneksi.php';
error_reporting(0);
// Cek Ketersediaan Cookie Akun
if (empty($_COOKIE['account_username'])) {
  setcookie("tempinput", "Harap Login Terlebih Dahulu", time() + 2 * 24 * 60 * 60);
  header('location: login.php');
}

// Cek Level Admin atau Bukan
if ($_COOKIE['account_level'] != "Admin") {
  // Cek Level Pembeli atau Penjual
  if ($_COOKIE['account_level'] == "Penjual") {
    header('location: penjualan/index.php');
  } else if ($_COOKIE['account_level'] == "Pembeli") {
    header('location: dashboard/index.php');
  }
}

?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Job Hunter</title>

  <!-- CSS UNTUK SIDE BAR START -->
  <link rel="stylesheet" href="assets/kl/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/kl/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/kl/css/metisMenu.css">
  <!-- others css -->
  <link rel="stylesheet" href="assets/kl/css/typography.css">
  <link rel="stylesheet" href="assets/kl/css/default-css.css">
  <link rel="stylesheet" href="assets/kl/css/styles.css">
  <link rel="stylesheet" href="assets/kl/css/themify-icons.css">
  <!-- CSS UNTUK SIDE BAR END -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.js"
    integrity="sha512-uLlukEfSLB7gWRBvzpDnLGvzNUluF19IDEdUoyGAtaO0MVSBsQ+g3qhLRL3GTVoEzKpc24rVT6X1Pr5fmsShBg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

</head>

<body>
  <div class="page-container">
    <div class="sidebar-menu">
      <div class="sidebar-header">
        <a href="index.php"><img src="../logo.png" alt="logo" width="100%"></a>
      </div>
      <div class="main-menu">
        <div class="menu-inner">
          <nav>
            <ul class="metismenu" id="menu">
              <li class="<?php if ($_GET['kelola'] == ''); ?>">
                <a href="./?kelola="><i class='bx bxs-dashboard'></i><span>Dashboard</span></a>
              </li>
              <li class="<?php if ($_GET['kelola'] == 'report') {
                            echo "active";
                          } ?>">
                <a href="./?kelola=report"><i class='bx bxs-report'></i><span>Report</span></a>
              </li>

              <li>
                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout"></i><span>Kelola Data
                  </span></a>
                <ul class="collapse">
                  <!-- <ul class="active"> -->
                  <li class="<?php if ($_GET['kelola'] == 'admin') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=admin">Data Admin</a>
                  </li>

                  <li class="<?php if ($_GET['kelola'] == 'user') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=user">Data User</a>
                  </li>

                  <li class="<?php if ($_GET['kelola'] == 'trans') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=trans">Data Transaksi</a>
                  </li>

                  <li class="<?php if ($_GET['kelola'] == 'dmoney') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=dmoney">Data Digital Money</a>
                  </li>

                  <li class="<?php if ($_GET['kelola'] == 'faq') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=faq">Data FAQ</a>
                  </li>

                  <li class="<?php if ($_GET['kelola'] == 'jobs') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=jobs">Data Jobs</a>
                  </li>

                  <li class="<?php if ($_GET['kelola'] == 'ktjobs') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=ktjobs">Data Kategori Jobs</a>
                  </li>

                  <li class="<?php if ($_GET['kelola'] == 'review') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=review">Data Review</a>
                  </li>

                  <li class="<?php if ($_GET['kelola'] == 'statrans') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=statrans">Data Status Transaksi</a>
                  </li>
                  <li class="<?php if ($_GET['kelola'] == 'stauser') {
                                echo "active";
                              } ?>">
                    <a href="./?kelola=stauser">Data Status User</a>
                  </li>
                </ul>
              </li>

              <li>
                <a href="logout.php"><span>Logout</span></a>
              </li>

            </ul>
          </nav>
        </div>
      </div>
    </div>

    <div class="main-content">
      <div class="header-area">
        <div class="row align-items-center">
          <div class="col-md-6 col-sm-8 clearfix">
            <div class="nav-btn pull-left">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <div class="search-box pull-left">
              <form action="#">
                <h5 style="margin-top:8px;">Hi! <?php echo $_COOKIE['account_username']; ?>, anda
                  login sebagai
                  <?php echo $_COOKIE['account_level']; ?> </h5>
              </form>
            </div>
          </div>

          <!-- profile info & task notification -->
          <div class="col-md-6 col-sm-4 clearfix">
            <ul class="notification-area pull-right">
              <li>
                <h6>
                  <div class="date">
                    <script type='text/javascript'>
                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                      'September', 'Oktober', 'November', 'Desember'
                    ];
                    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    var date = new Date();
                    var day = date.getDate();
                    var month = date.getMonth();
                    var thisDay = date.getDay(),
                      thisDay = myDays[thisDay];
                    var yy = date.getYear();
                    var year = (yy < 1000) ? yy + 1900 : yy;
                    document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
                    </script></b>
                  </div>
                </h6>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- page title area start -->
      <div class="page-title-area">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
              <h4 class="page-title pull-left">Dashboard</h4>
              <ul class="breadcrumbs pull-left">
                <!-- <li><a href="index.php">Kelola Data</a></li> -->
                <!-- <li><span>Lapangan</span></li> -->
              </ul>
            </div>
          </div>

          <div class="col-sm-6 clearfix">
            <div class="user-profile pull-right" style="color:black; padding:0px;">
              <!-- <img src="assets/img/futsal.png" width="220px" class="user-name dropdown-toggle" data-toggle="dropdown"> -->
            </div>
          </div>

        </div>
      </div>
      <!-- page title area end -->

      <div class="main-content-inner">

        <div class="row mt-5 mb-5">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <!-- isi konten disini -->
                <?php include("kelola.php") ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <div class="footer-area">
        <p>Copyright JobHunter 2021</p>
      </div>
    </footer>
  </div>

  <!-- jquery latest version -->
  <!-- JS UNTUK SIDE BAR DROPDOWN -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="assets/kl/js/metisMenu.min.js"></script>
  <script src="assets/kl/js/scripts.js"></script>
  <script src="assets/kl/js/bootstrap.min.js"></script>
  <!-- JS UNTUK SIDE BAR DROPDOWN END-->

  <!-- JS BELUM DISELEKSI START -->
  <!-- jquery latest version -->
  <!-- bootstrap 4 js -->
  <script src="assets/kl/js/popper.min.js"></script>
  <script src="assets/kl/js/bootstrap.min.js"></script>
  <script src="assets/kl/js/owl.carousel.min.js"></script>
  <script src="assets/kl/js/jquery.slimscroll.min.js"></script>
  <script src="assets/kl/js/jquery.slicknav.min.js"></script>
  <!-- Start datatable js -->
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <!-- start chart js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
  <!-- start highcharts js -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <!-- start zingchart js -->
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
  <script>
  zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
  ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
  </script>
  <!-- all line chart activation -->
  <script src="assets/kl/js/line-chart.js"></script>
  <!-- all pie chart -->
  <script src="assets/kl/js/pie-chart.js"></script>
  <!-- others plugins -->
  <script src="assets/kl/js/plugins.js"></script>

  <!-- JS BELUM DISELEKSI END -->
</body>

</html>