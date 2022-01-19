<?php


if (isset($_POST['update'])) {
  // Definisi Variabel
  // $v_IDsekarang = $_POST['IDsekarang'];
  $v_idTransaksi = $_POST['idTransaksi'];
  $v_idJob = $_POST['idJob'];
  $v_username = $_POST['username'];
  $v_tanggaltransaksi = $_POST['tanggal_transaksi'];
  $v_statustransaksi = $_POST['idStatusTrans'];

  // // Cek Kekosongan Data
  // if (empty($v_idTransaksi) || empty($v_idJob) || empty($v_username) || empty($v_tanggaltransaksi) || empty($v_statustransaksi)) {
  //   setcookie("tempinput", "Ada data yang kosong. Mohon periksa kembali", time() + 2 * 24 * 60 * 60);

  //   // header('location: edit_transaksi.php?IDtransaksi='.$v_idTransaksi);
  //   exit();
  // }

  // Bagian Edit
  $query = mysqli_query($koneksi, "UPDATE transaksi SET idTransaksi='$v_idTransaksi', idJob='$v_idJob', idStatusTrans='$v_statustransaksi', username='$v_username', tanggal_transaksi='$v_tanggaltransaksi' WHERE idTransaksi='$v_idTransaksi'") or die($koneksi);

  if ($query) {
    setcookie("tempinput", "Edit Data Transaksi Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: ?kelola=trans');
  } else {
    setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: ?kelola=trans');
  }
};

if (isset($_POST['hapus'])) {
  $v_idTransaksi = $_POST['idTransaksi'];

  $query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE IdTransaksi='$v_idTransaksi'");
  $array = mysqli_fetch_array($query);

  // echo $array['IdTransaksi'];

  $query = mysqli_query($koneksi, "DELETE FROM transaksi WHERE IdTransaksi='$v_idTransaksi'");

  if ($query) {
    setcookie("tempinput", "Hapus Transaksi Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=trans');
  } else {
    setcookie("tempinput", "Hapus Transaksi Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=trans');
  }
};

?>

<div class="container-fluid">
  <h3 class="text-dark mb-4">DATA TRANSAKSI</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit"
          value="Tambah Data Transaksi">
      </div>
    </div>


    <div class="card-body">

      <div class="row">
        <div class="col-md-6 text-nowrap">
          <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
            <label>Show&nbsp;<select class="form-control form-control-sm custom-select custom-select-sm">
                <option value="10" selected="">20</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>&nbsp;</label>
          </div>
        </div>

        <div class="col-md-6">
          <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input type="search"
                class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label>
          </div>
        </div>
      </div>


      <!-- TABEL DATA -->
      <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
        <table class="table my-0" id="dataTable">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Transaksi</th>
              <th>ID Job</th>
              <th>Username</th>
              <th>Tanggal Transaksi</th>
              <th>Status Transaksi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT transaksi.*, jobs.idJob, user.username, statustransaksi.StatusTrans FROM transaksi
                    JOIN jobs ON jobs.idJob = transaksi.idJob
                    JOIN statustransaksi ON statustransaksi.idStatusTrans = transaksi.idStatusTrans
                    JOIN user ON user.username = transaksi.username");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_idTransaksi = $record['0'];

            ?>

            <tr>
              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td><?= $record['idJob']; ?></td>
              <td><?= $record['username']; ?></td>
              <td><?= $record['4']; ?></td>
              <td><?= $record['StatusTrans']; ?></td>
              <td>
                <button style="margin-bottom: 3px;" data-toggle="modal" data-target="#edit<?= $v_idTransaksi; ?>"
                  class="btn btn-success editbtn">Edit</button>

                <button data-toggle="modal" data-target="#del<?= $v_idTransaksi; ?>" class="btn btn-danger">Del</button>
              </td>
            </tr>



            <!-- The modal EDIT-->
            <div class="modal fade" id="edit<?= $v_idTransaksi; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Transaksi : <?php echo $record['0'] ?> -
                        <?php echo $record['username'] ?>[<?php echo $record['4'] ?>]</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <label for="idTransaksi">ID Transaksi</label>
                      <input name="idTransaksi" id="idTransaksi" type="text" class="form-control"
                        value="<?php echo $record['idTransaksi'] ?>">

                      <label for="idJob">ID Job</label>
                      <input name="idJob" id="idJob" type="text" class="form-control"
                        value="<?php echo $record['idJob'] ?>">

                      <label for="username">Username</label>
                      <input name="username" id="username" type="text" class="form-control"
                        value="<?php echo $record['username'] ?>">

                      <label for="tanggal_transaksi">Tanggal Transaksi</label>
                      <input name="tanggal_transaksi" id="tanggal_transaksi" type="text" class="form-control"
                        value="<?php echo $record['tanggal_transaksi'] ?>">

                      <label for="idStatusTrans">Status Trans</label>
                      <input name="idStatusTrans" id="idStatusTrans" type="text" class="form-control"
                        value="<?php echo $record['idStatusTrans'] ?>">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success" name="update">Simpan Edit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>



            <!-- The Modal Hapus-->
            <div class="modal fade" id="del<?= $v_idTransaksi; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus Transaksi : <?php echo $record['0'] ?> -
                        <?php echo $record['username'] ?> [<?php echo $record['4'] ?>]</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus Transaksi ini dari daftar?
                      <input type="hidden" name="idTransaksi" value="<?= $v_idTransaksi; ?>">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                    </div>

                  </form>
                </div>
              </div>
            </div>

            <?php $i++; ?>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div class="row">
        <div class="col-md-6 align-self-center">
          <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 20 of 27
          </p>
        </div>

        <div class="col-md-6">
          <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
            <ul class="pagination">
              <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">«</span>
                </a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">»</span></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Modal input insert-->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambahkan Data Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tambah/ttrans.php" method="post">
          <div class="form-group">
            <label>ID Transaksi</label>
            <input name="idTransaksi" type="text" class="form-control" placeholder="ID Transaksi" required>
          </div>

          <div class="form-group">
            <label>ID Job</label>
            <input name="idJob" type="text" class="form-control" placeholder="ID Job" required>
          </div>

          <div class="form-group">
            <label for="">Status Trans</label>
            <select name="idStatusTrans" id="" class="custom-select form-control">

              <option selected name="idStatusTrans">Status Trans</option>
              <option value="1" name="idStatusTrans">STR-1 (Diterima)</option>
              <option value="2" name="idStatusTrans">STR-2 (Ditolak)</option>

            </select>
          </div>

          <div class="form-group">
            <label>Username</label>
            <input name="username" type="text" class="form-control" placeholder="Username" required>
          </div>

          <div class="form-group">
            <label>Tanggal Transaksi</label>
            <input name="tanggal_transaksi" type="text" class="form-control" placeholder="Tanggal Transaksi" required>
          </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>