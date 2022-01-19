<?php


if (isset($_POST['update'])) {
  // Definisi Variabel
  $v_IDsekarang = $_POST['IDsekarang'];
  $v_idStatusTrans = $_POST['idStatusTrans'];
  $v_StatusTrans = $_POST['StatusTrans'];


  // Cek Kekosongan Data
  if (empty($v_IDsekarang) || empty($v_idStatusTrans) || empty($v_StatusTrans)) {
    setcookie("tempinput", "Ada data yang kosong. Mohon periksa kembali", time() + 2 * 24 * 60 * 60);

    header('location: index.php?kelola=statrans');
    exit();
  }

  // Bagian Edit
  $query = mysqli_query($koneksi, "UPDATE statustransaksi SET idStatusTrans='$v_idStatusTrans', StatusTrans='$v_StatusTrans' WHERE idStatusTrans='$v_IDsekarang'") or die($koneksi);

  if ($query) {
    setcookie("tempinput", "Edit Data Transaksi Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=statrans');
  } else {
    setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=statrans');
  }
};



if (isset($_POST['hapus'])) {
  $v_idStatusTrans = $_POST['idStatusTrans'];

  $query = mysqli_query($koneksi, "SELECT * FROM statustransaksi WHERE idStatusTrans='$v_idStatusTrans'");
  $array = mysqli_fetch_array($query);

  $query = mysqli_query($koneksi, "DELETE FROM statustransaksi WHERE idStatusTrans='$v_idStatusTrans'");

  if ($query) {
    setcookie("tempinput", "Hapus Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=statrans');
  } else {
    setcookie("tempinput", "Hapus Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=statrans');
  }
};


?>

<div class="container-fluid">
  <h3 class="text-dark mb-4">DATA STATUS TRANSAKSI</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit"
          value="Tambah Data Status Transaksi">
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
              <th>ID Status Transaksi</th>
              <th>Status Transaksi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT * FROM statustransaksi");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_idStatusTrans = $record['0'];
            ?>

            <tr>
              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td><?= $record['1']; ?></td>
              <td>
                <button data-toggle="modal" data-target="#edit<?= $v_idStatusTrans; ?>"
                  class="btn btn-success editbtn">Edit</button>

                <button data-toggle="modal" data-target="#del<?= $v_idStatusTrans; ?>"
                  class="btn btn-danger">Del</button>
              </td>
            </tr>


            <!-- The modal EDIT-->
            <div class="modal fade" id="edit<?= $v_idStatusTrans; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Status Transaksi : <?php echo $record['0'] ?> -
                        <?php echo $record['1'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <label for="idStatusTrans">ID Status Transaksi</label>
                      <input name="IDsekarang" id="IDsekarang" type="text" class="form-control" hidden
                        value="<?php echo $record['idStatusTrans'] ?>">
                      <input name="idStatusTrans" id="idStatusTrans" type="text" class="form-control"
                        value="<?php echo $record['idStatusTrans'] ?>">

                      <label for="StatusTrans">Status Transaksi</label>
                      <input name="StatusTrans" id="StatusTrans" type="text" class="form-control"
                        value="<?php echo $record['StatusTrans'] ?>">
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
            <div class="modal fade" id="del<?= $v_idStatusTrans; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus Status Transaksi : <?php echo $record['0'] ?> -
                        <?php echo $record['1'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus Data Status Transaksi ini dari daftar?
                      <input type="hidden" name="idStatusTrans" value="<?= $v_idStatusTrans; ?>">
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

<!-- Modal input insert -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambahkan Data Status Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tambah/tstatustrans.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>ID Status Transaksi</label>
            <input name="idStatusTrans" type="text" class="form-control" placeholder="ID Status Transaksi" required>
          </div>

          <div class="form-group">
            <label>Status Transaksi</label>
            <input name="StatusTrans" type="text" class="form-control" placeholder="Status Transaksi" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>