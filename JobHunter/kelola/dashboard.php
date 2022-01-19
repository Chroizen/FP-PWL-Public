<?php

// get data
// ambil data total cust
$cust = mysqli_query($koneksi, "SELECT * FROM user");
$count_cust = mysqli_num_rows($cust);

// total job
$job = mysqli_query($koneksi, "SELECT * FROM jobs");
$count_job = mysqli_num_rows($job);

// total transaksi
$trans = mysqli_query($koneksi, "SELECT * FROM transaksi");
$count_trans = mysqli_num_rows($trans);

?>

<!-- isi konten disini -->
<!-- <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css"> -->
<link rel="stylesheet" href="assets/kl/css/style_dashboard.css">

<div class="container-fluid">
  <h3 class="text-dark mb-4">Statistik Transaksi</h3>
  <div class="row">
    <div class="col-md-6 col-xl-3 mb-4">
      <div class="card shadow border-left-primary py-2">
        <div class="card-body">
          <div class="row align-items-center no-gutters">
            <div class="col mr-2">
              <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Total Customer</span>
              </div>
              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $count_cust; ?></span>
                <i class='bx bx-user' style="font-size: 1rem;"></i>
              </div>

            </div>
          </div>
        </div>
        <div class="card-footer">
          <li class="<?php if ($_GET['kelola'] == 'user') {
                        echo "active";
                      } ?>" style="list-style:none;">
            <a href="./?kelola=user"><small>Info Lengkap <span><i class='bx bx-chevron-right'
                    style="font-size:2rem; position:absolute;"></i></span></small></a>
          </li>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
      <div class="card shadow border-left-warning py-2">
        <div class="card-body">
          <div class="row align-items-center no-gutters">
            <div class="col mr-2">
              <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Total Data Job</span>
              </div>
              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $count_job; ?></span>
                <i class='bx bx-station' style="font-size: 1rem;"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <li class="<?php if ($_GET['kelola'] == 'jobs') {
                        echo "active";
                      } ?>" style="list-style:none;">
            <a href="./?kelola=jobs"><small>Info Lengkap <span><i class='bx bx-chevron-right'
                    style="font-size:2rem; position:absolute;"></i></span></small></a>
          </li>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
      <div class="card shadow border-left-success py-2">
        <div class="card-body">
          <div class="row align-items-center no-gutters">
            <div class="col mr-2">
              <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Total Transaksi</span>
              </div>
              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $count_trans; ?></span>
                <i class='bx bx-shopping-bag' style="font-size: 1rem;"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <li class="<?php if ($_GET['kelola'] == 'trans') {
                        echo "active";
                      } ?>" style="list-style:none;">
            <a href="./?kelola=trans"><small>Info Lengkap <span><i class='bx bx-chevron-right'
                    style="font-size:2rem; position:absolute;"></i></span></small></a>
          </li>
        </div>
      </div>
    </div>


  </div>
</div>


<br>
<div>
  <div id="data_transaksi">
  </div>
</div>