<?php

if (isset($_POST['update'])) {
  // Definisi Variabel
  $v_IDsekarang = $_POST['IDsekarang'];
  $v_idStatusUser = $_POST['idStatusUser'];
  $v_namaStatus = $_POST['namaStatus'];

  // Cek Kekosongan Data
  if (empty($v_IDsekarang) || empty($v_idStatusUser) || empty($v_namaStatus)) {
    setcookie("tempinput", "Ada data yang kosong. Mohon periksa kembali", time() + 2 * 24 * 60 * 60);
    // header('location: edit_status_user.php?idStatusUser='.$v_idStatusUser);
    exit();
  }

  // Bagian Edit
  $query = mysqli_query($koneksi, "UPDATE statususer SET idStatusUser='$v_idStatusUser', namaStatus='$v_namaStatus' WHERE idStatusUser='$v_IDsekarang'") or die($koneksi);

  if ($query) {
    setcookie("tempinput", "Edit Data User Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=statrans');
  } else {
    setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=statrans');
  }
};



if (isset($_POST['hapus'])) {
  $v_idStatusUser = $_POST['idStatusUser'];

  $query = mysqli_query($koneksi, "SELECT * FROM statususer WHERE idStatusUser='$v_idStatusUser'");
  $array = mysqli_fetch_array($query);

  $query = mysqli_query($koneksi, "DELETE FROM statususer WHERE idStatusUser='$v_idStatusUser'");

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
  <h3 class="text-dark mb-4">DATA STATUS USER</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit"
          value="Tambah Data Status User">
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
              <th>ID Status User</th>
              <th>Nama Status User</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT * FROM statususer");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_idStatusUser = $record['0']
            ?>

            <tr>
              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td><?= $record['1']; ?></td>
              <td>
                <button data-toggle="modal" data-target="#edit<?= $v_idStatusUser; ?>"
                  class="btn btn-success editbtn">Edit</button>

                <button data-toggle="modal" data-target="#del<?= $v_idStatusUser; ?>"
                  class="btn btn-danger">Del</button>
              </td>
            </tr>




            <!-- The modal EDIT-->
            <div class="modal fade" id="edit<?= $v_idStatusUser; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Status User : <?php echo $record['0'] ?> -
                        <?php echo $record['1'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <label for="idStatusTrans">ID Status User</label>
                      <input name="IDsekarang" id="IDsekarang" type="text" class="form-control" hidden
                        value="<?php echo $record['idStatusUser'] ?>">
                      <input name="idStatusUser" id="idStatusUser" type="text" class="form-control"
                        value="<?php echo $record['idStatusUser'] ?>">

                      <label for="namaStatus">Nama Status</label>
                      <input name="namaStatus" id="namaStatus" type="text" class="form-control"
                        value="<?php echo $record['namaStatus'] ?>">
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
            <div class="modal fade" id="del<?= $v_idStatusUser; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus Status User : <?php echo $record['0'] ?> -
                        <?php echo $record['1'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus Data Status User ini dari daftar?
                      <input type="hidden" name="idStatusUser" value="<?= $v_idStatusUser; ?>">
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
        <h5 class="modal-title" id="myModalLabel">Tambahkan Data Status User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tambah/tstatususer.php" method="post">
          <div class="form-group">
            <label>ID Status User</label>
            <input name="idStatusUser" type="text" class="form-control" placeholder="ID Status User" required>
          </div>

          <div class="form-group">
            <label>Nama Status User</label>
            <input name="namaStatus" type="text" class="form-control" placeholder="Nama Status User" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>