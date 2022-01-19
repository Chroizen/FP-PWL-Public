<?php
session_start();
require_once '../koneksi.php';

require_once '../koneksi.php';
// session_start();
// Cek Ketersediaan Cookie Akun
if (empty($_COOKIE['account_username'])) {
  setcookie("tempinput", "Harap Login Terlebih Dahulu", time() + 2 * 24 * 60 * 60);
  header('location: ../login.php');
}
// Cek Level Penjual atau Bukan
if ($_COOKIE['account_level'] != "Pembeli") {
  // Cek Level Pembeli atau Penjual
  if ($_COOKIE['account_level'] == "Admin") {
    header('location: ../index.php');
  } else if ($_COOKIE['account_level'] == "Penjual") {
    header('location: ../penjualan/index.php');
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php

error_reporting(0);
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - JobHunter</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/carousel/">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="assets/cust/bootstrap/css/bootstrap.min.profil.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <!-- footer -->
  <link rel="stylesheet" href="assets/cust/bootstrap/css/bootstrap.min.footercust.css">
  <link href="assets/cust/bootstrap/css/bootstrap.min.homecust.css" rel="stylesheet">

  <!-- Box Icons di web terus klik github -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="../assets/css/job.css" rel="stylesheet">
  <style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
  </style>

  <!-- Custom styles for this template -->
  <link href="assets/cust/css/homecust_style.css" rel="stylesheet">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">JobHunter</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">Home</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">About Us</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="job_list.php">Jobs</a>
            </li>

          </ul>




          <div class="profil">

            <ul class="nav navbar-nav flex-nowrap ml-auto">
              <li class="nav-item dropdown no-arrow" role="presentation">
                <div class="nav-item dropdown no-arrow">
                  <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                    <label class="d-none d-lg-inline mr-2 text-gray-600 small">
                      <?php echo $_COOKIE['account_username'] ?>
                      <!-- ddablue -->


                    </label>
                  </a>
                  <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                    <a class="dropdown-item" role="presentation" href="#">
                      <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile
                    </a>
                    <a class="dropdown-item" role="presentation" href="#">
                      <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings
                    </a>
                    <a class="dropdown-item" role="presentation" href="#">
                      <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" role="presentation" href="../logout.php">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout
                    </a>
                  </div>
                </div>
              </li>
            </ul>

          </div>
          <img class="profil_image" src="../assets/img/avatars/avatar1.jpeg" alt="">
        </div>
    </nav>
  </header>

  <main>

    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">

      <!-- <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
          aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div> -->

      <div class="carousel-inner">


        <!-- Job Items -->
        <div class="container py-5">
          <div class="row text-center text-white mb-5">
            <div class="col-lg-7 mx-auto">
              <h1 class="display-4">Product List</h1>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <!-- List group-->
              <ul class="list-group shadow">




                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM jobs");
                $rows = mysqli_num_rows($query);


                // echo $rows;
                while ($array = mysqli_fetch_array($query)) {
                  // echo $array['nama_job'];
                  $job = $array['idJob'];
                  $q_job = mysqli_query($koneksi, "SELECT * FROM review WHERE idJob='$job'");
                  $arrq_job = mysqli_num_rows($q_job);
                  echo "<li class='list-group-item'>
                    <!-- Custom content-->
                    <div class='media align-items-lg-center flex-column flex-lg-row p-3'>
                        <div class='media-body order-2 order-lg-1'>
                            <h5 class='mt-0 font-weight-bold mb-2'><a href='job_see.php?id=" . $array['idJob'] . "'>" . $array['nama_job'] . "</a></h5>
                            <p class='font-italic text-muted mb-0 small'>" . $array['desc_job'] . "</p>
                            <div class='d-flex align-items-center justify-content-between mt-1'>
                                <h6 class='font-weight-bold my-2'>Rp. " . $array['harga_job'] . "</h6>
                                <ul class='list-inline small'>
                                    <li class='list-inline-item m-0'><i class='fa fa-star text-success'></i></li> " . $arrq_job . "
                                    
                                </ul>
                            </div>
                        
                    </div> <!-- End -->
                </li>";
                }

                ?>


              </ul> <!-- End -->
            </div>
          </div>
        </div>

        <!-- Job Items -->




      </div>

      <!-- <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden"></span>
      </button>

      <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden"></span>
      </button> -->
    </div>
  </main>

  <?php include("cust.php") ?>

  <br>
  <br><br>
  <footer class="page-footer dark">
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <h5>Get started</h5>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Sign up</a></li>
            <li><a href="#">Downloads</a></li>
          </ul>
        </div>
        <div class="col-sm-3">
          <h5>About us</h5>
          <ul>
            <li><a href="#">Company Information</a></li>
            <li><a href="#">Contact us</a></li>
            <li><a href="#">Reviews</a></li>
          </ul>
        </div>
        <div class="col-sm-3">
          <h5>Support</h5>
          <ul>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Help desk</a></li>
            <li><a href="#">Forums</a></li>
          </ul>
        </div>
        <div class="col-sm-3">
          <h5>Legal</h5>
          <ul>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Terms of Use</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <p>© 2021 Copyright Text</p>
    </div>
  </footer>

</body>

<!-- JAVASCRIPT -->
<script src="assets/cust/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/cust/js/jquery.min.js"></script>
<script src="assets/cust/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/cust/js/chart.min.js"></script>
<script src="assets/cust/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="assets/cust/js/theme.js"></script>

</html>