<!-- isi konten disini -->
<!-- <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css"> -->
<link rel="stylesheet" href="assets/kl/css/style_dashboard.css">

<div class="container-fluid">
  <h3 class="text-dark mb-4">Laporan Data</h3>
  <div class="row">
    <div class="col-md-6 col-xl-3 mb-4">
      <div class="card shadow border-left-primary py-2">
        <div class="card-body">
          <div class="row align-items-center no-gutters">
            <div class="col mr-2">
              <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Laporan Transaksi</span>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <li class="<?php if ($_GET['kelola'] == 'cetak_trans') {
                        echo "active";
                      } ?>" style="list-style:none;">
            <a href="./?kelola=cetak_trans"><small>Unduh Dokumen<span><i class='bx bx-chevron-right'
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